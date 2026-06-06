# Backend: Configuração de Agendamento do Médico

## 📋 O que o Frontend espera

O frontend está pronto para:
1. **Enviar** requisições para `PUT /doctors/{id}/schedule-config`
2. **Receber** dados de `GET /doctors/{id}/schedule-config`
3. **Incluir** `scheduleConfig` quando busca dados do médico em `GET /doctors/{id}`

---

## 🗄️ Tabela no Banco de Dados

Crie a tabela `doctor_schedule_configs`:

```sql
CREATE TABLE doctor_schedule_configs (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    doctor_id BIGINT UNSIGNED NOT NULL UNIQUE,
    slot_duration VARCHAR(8) DEFAULT '00:20:00' NOT NULL,
    slot_label_interval VARCHAR(8) DEFAULT '00:20:00' NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);
```

### Explicação:
- `slot_duration`: Intervalo do slot no calendário (ex: "00:15:00", "00:20:00", "00:30:00", "00:45:00", "01:00:00")
- `slot_label_interval`: Mesmo valor do `slot_duration` (para consistência)
- `UNIQUE` em `doctor_id`: Um médico tem apenas uma configuração

---

## 🔌 Endpoints Necessários

### 1️⃣ GET /doctors/{id}/schedule-config
**Buscar configuração de agendamento do médico**

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "doctor_id": 5,
    "slot_duration": "00:20:00",
    "slot_label_interval": "00:20:00"
  }
}
```

**Comportamento:**
- Se a configuração não existir, crie uma com valores padrão ("00:20:00")
- Retorne sempre a configuração encontrada ou criada

---

### 2️⃣ PUT /doctors/{id}/schedule-config
**Atualizar configuração de agendamento do médico**

**Request Body:**
```json
{
  "slot_duration": "00:30:00",
  "slot_label_interval": "00:30:00"
}
```

**Response (200):**
```json
{
  "data": {
    "id": 1,
    "doctor_id": 5,
    "slot_duration": "00:30:00",
    "slot_label_interval": "00:30:00"
  }
}
```

**Comportamento:**
- Se não existir, crie
- Se existir, atualize
- Validar que `slot_duration` está em um dos valores aceitos: "00:15:00", "00:20:00", "00:30:00", "00:45:00", "01:00:00"

---

### 3️⃣ GET /doctors/{id}
**Modificar resposta para incluir schedule_config**

A resposta existente precisa incluir o objeto `schedule_config`:

**Response (200):**
```json
{
  "data": {
    "id": 5,
    "name": "Dr. João Silva",
    "email": "joao@example.com",
    "... outros campos ...",
    "schedule_config": {
      "id": 1,
      "doctor_id": 5,
      "slot_duration": "00:20:00",
      "slot_label_interval": "00:20:00"
    }
  }
}
```

---

## ✅ Validações

```php
// Valores aceitos para slot_duration
$validDurations = [
    '00:15:00', // 15 minutos
    '00:20:00', // 20 minutos
    '00:30:00', // 30 minutos
    '00:45:00', // 45 minutos
    '01:00:00'  // 1 hora
];

if (!in_array($request->slot_duration, $validDurations)) {
    return response()->json([
        'message' => 'Invalid slot duration',
        'errors' => ['slot_duration' => ['The slot duration field must be one of: ' . implode(', ', $validDurations)]]
    ], 422);
}
```

---

## 🛠️ Implementação (Exemplo Laravel)

### Model
```php
class Doctor extends Model
{
    public function scheduleConfig()
    {
        return $this->hasOne(DoctorScheduleConfig::class);
    }
}

class DoctorScheduleConfig extends Model
{
    protected $fillable = ['doctor_id', 'slot_duration', 'slot_label_interval'];
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
```

### Controller
```php
class DoctorScheduleConfigController extends Controller
{
    public function show($doctorId)
    {
        $config = DoctorScheduleConfig::firstOrCreate(
            ['doctor_id' => $doctorId],
            ['slot_duration' => '00:20:00', 'slot_label_interval' => '00:20:00']
        );
        return response()->json(['data' => $config]);
    }
    
    public function update(Request $request, $doctorId)
    {
        $validated = $request->validate([
            'slot_duration' => 'required|in:00:15:00,00:20:00,00:30:00,00:45:00,01:00:00',
            'slot_label_interval' => 'required|in:00:15:00,00:20:00,00:30:00,00:45:00,01:00:00',
        ]);
        
        $config = DoctorScheduleConfig::updateOrCreate(
            ['doctor_id' => $doctorId],
            $validated
        );
        
        return response()->json(['data' => $config]);
    }
}
```

### Routes
```php
Route::get('/doctors/{id}/schedule-config', [DoctorScheduleConfigController::class, 'show']);
Route::put('/doctors/{id}/schedule-config', [DoctorScheduleConfigController::class, 'update']);
```

### Modificar GET /doctors/{id}
```php
public function show($id)
{
    $doctor = Doctor::with(['workTimes', 'plans', 'information', 'scheduleConfig'])->find($id);
    // ... return response
}
```

---

## 🎯 Checklist

- [ ] Criar tabela `doctor_schedule_configs`
- [ ] Criar Model `DoctorScheduleConfig`
- [ ] Criar Controller ou adicionar methods existentes
- [ ] Criar routes GET e PUT para schedule-config
- [ ] Modificar endpoint GET /doctors/{id} para incluir scheduleConfig
- [ ] Testar com valores diferentes (15, 20, 30, 45, 60 minutos)
- [ ] Testar que a configuração é salva e recuperada corretamente

---

## 🔗 Frontend já está preparado para:

✅ Exibir Card de "Configuração do calendário" no perfil do médico  
✅ Permitir selecionar intervalo (15, 20, 30, 45, 60 minutos)  
✅ Salvar a configuração quando clicar em "Salvar"  
✅ Aplicar dinamicamente o intervalo no calendário ao agendar consultas  

**Quando o backend estiver pronto, tudo funcionará automaticamente!** 🚀
