<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Plan;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class ImportController extends Controller
{
    private LoggerInterface $logger;

    /**
     * @return void
     */
    public function __construct()
    {
        $this->logger = Log::channel('import');
    }

    /**
     * @return void
     */
    public function import(): Response
    {
        $this->logger->debug('A importação de dados foi iniciada.');

        $this->down();

        // $this->importPatients();
        // $this->importAppointments();
        // $this->importReports();
        // $this->importCID();

        $this->importReports();

        $this->up();

        $this->logger->debug('A importação de dados foi concluída.');

        return response()->noContent();
    }

    /**
     * @return void
     */
    private function up(): void
    {
        Artisan::call('up');
        $this->logger->debug('O modo de manutenção foi desativado.');
    }

    /**
     * @return void
     */
    private function down(): void
    {
        Artisan::call('down');
        $this->logger->debug('O modo de manutenção foi ativado.');
    }

    private function fail(string $message = '', array $context = []): void
    {
        $this->up();

        $this->logger->debug($message, $context);
        $this->logger->debug('A importação de dados foi interrompida devido a uma falha.');

        abort(500);
    }

    private function importCID(): void
    {
        $this->logger->debug('A importação do CID foi iniciada.');

        $count = 0;

        while ($cid = $this->getCID($count)) {
            DB::table('cid')->insert($cid);
            $count += count($cid);

            $this->logger->debug(sprintf('Foram importados %s registros até o momento.', $count));
        }

        $this->logger->debug('A importação do CID foi concluída.');
    }

    private function getCID(int $limit): array
    {
        $request = Http::onmed()->withOptions([
            'query' => [
                'classe' => 'cadastro',
                'funcao' => 'pesquisar_cid',
                'conta' => config('import.api_account'),
                'idusuario' => config('import.api_user_id'),
                'idclinica' => config('import.api_clinic_id'),
                'idsessao' => config('import.api_session_id'),
                'timezone' => config('import.api_timezone')
            ]
        ]);

        $response = $request->post('/', [
            'descricao' => '',
            'limit_inicio' => $limit
        ]);

        if ($response->failed()) {
            $this->logger->debug('Ocorreu uma falha ao obter dados do OnMed.');
            $this->fail();
        }

        $data = $response->json();

        if ($data['situacao'] != 'true') {
            $this->logger->debug('Ocorreu uma falha de autenticação ao obter dados do OnMed.');
            $this->fail();
        }

        return array_map(function ($cid) {
            return [
                'old_id' => trim($cid['id']),
                'description' => trim($cid['descricao']),
                'code' => trim($cid['cid10'])
            ];
        }, array_key_exists('dados', $data) ? $data['dados'] : []);
    }

    /**
     * @return void
     */
    private function importPatients(): void
    {
        $this->logger->debug('A importação de pacientes foi iniciada.');

        $count = 0;

        while ($patients = $this->getPatients($count)) {
            DB::table('patients')->insert($patients);
            $count += count($patients);

            $this->logger->debug(sprintf('Foram importados %s pacientes até o momento.', $count));
        }

        $this->logger->debug('A importação de pacientes foi concluída.');
    }

    /**
     * @param int $limit
     * @return array
     */
    private function getPatients(int $limit): array
    {
        $request = Http::onmed()->withOptions([
            'query' => [
                'classe' => 'cadastro',
                'funcao' => 'pesquisarpacientesNovoSistema',
                'conta' => config('import.api_account'),
                'idusuario' => config('import.api_user_id'),
                'idclinica' => config('import.api_clinic_id'),
                'idsessao' => config('import.api_session_id'),
                'timezone' => config('import.api_timezone')
            ]
        ]);

        $response = $request->post('/', [
            'prontuario' => '',
            'nome' => '',
            'pac_inativos' => 'false',
            'ordenar' => 'true',
            'data_nasc' => '',
            'cpf' => '',
            'meuspacientes' => 'false',
            'todasasclinicas' => 'false',
            'limit_inicio' => $limit
        ]);

        if ($response->failed()) {
            $this->logger->debug('Ocorreu uma falha ao obter dados do OnMed.');
            $this->fail();
        }

        $data = $response->json();

        if ($data['situacao'] != 'logado') {
            $this->logger->debug('Ocorreu uma falha de autenticação ao obter dados do OnMed.');
            $this->fail();
        }

        return array_map(function ($patient) {
            return [
                'old_id' => trim($patient['id']),
                'name' => trim($patient['nome']),
                'phone' => str_replace(' ', '', $patient['celular']),
                'phone2' => str_replace(' ', '', $patient['telefone'])
            ];
        }, array_key_exists('dados', $data) ? $data['dados'] : []);
    }

    /**
     * @param int $id
     * @return array
     */
    private function getPatient(int $id): array
    {
        $request = Http::onmed()->withOptions([
            'query' => [
                'classe' => 'cadastro',
                'funcao' => 'dadospaciente',
                'conta' => config('import.api_account'),
                'idusuario' => config('import.api_user_id'),
                'idsessao' => config('import.api_session_id'),
                'timezone' => config('import.api_timezone')
            ]
        ]);

        $response = $request->post('/', [
            'idpac' => $id
        ]);

        if ($response->failed()) {
            $this->logger->debug('Ocorreu uma falha ao obter dados do OnMed.');
            $this->fail();
        }

        $data = $response->json();

        if ($data['situacao'] != 'logado') {
            $this->logger->debug('Ocorreu uma falha de autenticação ao obter dados do OnMed.');
            $this->fail();
        }

        return array_key_exists('id', $data) ? [
            'old_id' => trim($data['id']),
            'name' => trim($data['nome']),
            'phone' => str_replace(' ', '', $data['celular']),
            'phone2' => str_replace(' ', '', $data['foneres'])
        ] : [];
    }

    /**
     * @return void
     */
    private function importAppointments()
    {
        $this->logger->debug('A importação de agendamentos foi iniciada.');

        $start = Carbon::parse(config('import.start'));
        $end = Carbon::parse(config('import.end'));

        $doctors = Doctor::all();

        foreach ($doctors as $i => $doctor) {
            $date = $start->clone();

            while ($date->lessThanOrEqualTo($end)) {
                $appointments = $this->getAppointments($doctor, $date);

                foreach ($appointments as $appointment) {
                    $appointmentId = DB::table('appointments')->insertGetId($appointment['appointment']);
                    DB::table('events')->insert(array_merge($appointment['event'], ['event_id' => $appointmentId]));
                    DB::table('payments')->insert(array_map(fn(array $payment) => array_merge($payment, ['appointment_id' => $appointmentId]), $appointment['payments']));
                }

                if (!empty($appointments)) {
                    $this->logger->debug(sprintf('Os agendamentos no dia %s para o(a) médico(a) %s/%s (%s) foram importados.', $date->format('d/m/Y'), $i + 1, count($doctors), $doctor->user->name));
                } else {
                    $this->logger->debug(sprintf('Não há agendamentos no dia %s para o(a) médico(a) %s/%s (%s) para importar.', $date->format('d/m/Y'), $i + 1, count($doctors), $doctor->user->name));
                }

                $date->addDay();
            }
        }

        $this->logger->debug('A importação de agendamentos foi concluída.');
    }

    /**
     * @param Doctor $doctor
     * @param Carbon $date
     * @return mixed
     */
    private function getAppointments(Doctor $doctor, Carbon $date): array
    {
        $patients = Patient::all();
        $plans = Plan::all();

        $appointmentTypes = config('import.appointment_types');
        $appointmentStatus = config('import.appointment_status');

        $request = Http::onmed()->withOptions([
            'query' => [
                'classe' => 'arquivo',
                'funcao' => 'selectagenda',
                'conta' => config('import.api_account'),
                'idusuario' => config('import.api_user_id'),
                'idclinica' => config('import.api_clinic_id'),
                'idsessao' => config('import.api_session_id'),
                'idmedico' => $doctor->old_id,
                'timezone' => config('import.api_timezone')
            ]
        ]);

        $response = $request->post('/', [
            'dataselec' => $date->format('d/m/Y'),
            'reconsulta' => 0,
            'idagendaSel' => 0
        ]);

        if ($response->failed()) {
            $this->logger->debug('Ocorreu uma falha ao obter dados do OnMed.');
            $this->fail();
        }

        $responseData = $response->json();

        if (!array_key_exists('situacao', $responseData)) {
            $this->logger->debug('Falha ao obter a situação.', $response);
            $this->fail();
        }

        if ($responseData['situacao'] != 'logado') {
            $this->logger->debug('Ocorreu uma falha de autenticação ao obter dados do OnMed.');
            $this->fail();
        }

        return array_map(function ($data) use ($doctor, $date, $patients, &$plans, $appointmentTypes, $appointmentStatus) {
            $plan = $plans->firstWhere('old_id', $data['idconvenio']);

            if (!$plan) {
                $plan = Plan::create([
                    'name' => $data['nomeconvenio'],
                    'old_id' => $data['idconvenio']
                ]);

                $plans = Plan::all();
            }

            $patient = $patients->firstWhere('old_id', $data['idpaciente']);

            if (!$patient) {
                $patient = $this->getPatient($data['idpaciente']);

                if (!$patient) {
                    $this->logger->debug(sprintf('Não há um paciente que corresponda ao ID OnMed #%s.', $data['idpaciente']));
                    $this->fail();
                }

                $patient = Patient::create($patient);
            }

            return [
                'event' => [
                    'date' => $date->toDateString(),
                    'time' => $data['hora'],
                    'duration' => $data['duracao'],
                    'doctor_id' => $doctor->id,
                    'type' => 'appointment'
                ],
                'appointment' => [
                    'patient_id' => $patient->id,
                    'plan_id' => $plan->id,
                    'comment' => $data['obs'],
                    'type' => array_key_exists($data['tipo'], $appointmentTypes) ? $appointmentTypes[$data['tipo']] : 'default',
                    'status' => array_key_exists($data['status'], $appointmentStatus) ? $appointmentStatus[$data['status']] : 1
                ],
                'payments' => $this->getPayments($data['idpaciente'], $data['idpacote'], $data['id'])
            ];
        }, array_key_exists('dados', $responseData) ? array_filter($responseData['dados'], function ($data) {
            return $data['idpaciente'] != 0;
        }) : []);
    }

    /**
     * @param int $patientId
     * @param int $packageId
     * @param int $appointmentId
     * @return array
     */
    private function getPayments(int $patientId, int $packageId, int $appointmentId): array
    {
        $request = Http::onmed()->withOptions([
            'query' => [
                'classe' => 'arquivo',
                'funcao' => 'selectpacotes',
                'conta' => config('import.api_account'),
                'idusuario' => config('import.api_user_id'),
                'idclinica' => config('import.api_clinic_id'),
                'idsessao' => config('import.api_session_id'),
                'timezone' => config('import.api_timezone')
            ]
        ]);

        $response = $request->post('/', [
            'idpaciente' => $patientId,
            'idpacote' => $packageId,
            'idagenda' => $appointmentId
        ]);

        if ($response->failed()) {
            $this->logger->debug('Ocorreu uma falha ao obter dados do OnMed.');
            $this->fail();
        }

        $data = $response->json();

        if ($data['situacao'] != 'logado') {
            $this->logger->debug('Ocorreu uma falha de autenticação ao obter dados do OnMed.');
            $this->fail();
        }

        return array_map(function (array $data) {
            return [
                'amount' => str_replace(',', '.', str_replace('.', '', str_replace('R$ ', '', $data['valor']))),
                'description' => $data['cheque']
            ];
        }, array_key_exists('dados_caixa', $data) ? $data['dados_caixa'] : []);
    }
}
