# Prompt para Desenvolvimento do Frontend - Clava API

## 📋 Visão Geral do Projeto

**Clava** é um sistema completo de agendamento médico que permite:
- Gerenciamento de médicos, pacientes e funcionários
- Agendamento de consultas
- Controle de indisponibilidades
- Prontuários e relatórios médicos
- Gestão de planos e especialidades
- Pagamentos

---

## 🎯 Objetivos do Frontend

Desenvolver uma aplicação web responsiva, intuitiva e segura que permita:
1. Autenticação de usuários
2. Gerenciamento completo de recursos (CRUD)
3. Agendamento e gestão de consultas
4. Visualização de prontuários médicos
5. Dashboard com informações relevantes
6. Relatórios e histórico médico

---

## 🛠️ Stack Tecnológico Recomendado

### Framework Principal
- **React 18+** ou **Vue 3** com TypeScript
- **Next.js** ou **Nuxt** para melhor estrutura de projeto

### UI e Styling
- **Tailwind CSS** para estilização
- **shadcn/ui** ou **Headless UI** para componentes
- **React Hook Form** para formulários
- **Zod** ou **Yup** para validação

### Requisições HTTP
- **Axios** com interceptadores para autenticação
- **TanStack Query (React Query)** para caching e sincronização

### Autenticação
- **JWT (Bearer Token)** via localStorage/sessionStorage
- Armazenamento seguro do token
- Interceptadores automáticos de requisições

### Utilities
- **date-fns** para manipulação de datas
- **clsx** ou **classnames** para classes condicionais
- **zustand** ou **Pinia** para gerenciamento de estado

### Dev Tools
- **Vite** para build rápido
- **ESLint + Prettier** para code quality
- **Vitest** ou **Jest** para testes

---

## 📁 Estrutura do Projeto

```
frontend/
├── public/
├── src/
│   ├── components/
│   │   ├── common/              # Componentes reutilizáveis
│   │   │   ├── Navbar.tsx
│   │   │   ├── Sidebar.tsx
│   │   │   ├── Modal.tsx
│   │   │   └── Loading.tsx
│   │   ├── auth/                # Componentes de autenticação
│   │   │   ├── LoginForm.tsx
│   │   │   └── ProtectedRoute.tsx
│   │   ├── forms/               # Formulários reutilizáveis
│   │   │   ├── SpecialtyForm.tsx
│   │   │   ├── DoctorForm.tsx
│   │   │   ├── PatientForm.tsx
│   │   │   └── AppointmentForm.tsx
│   │   ├── tables/              # Tabelas e listagens
│   │   │   ├── SpecialtyTable.tsx
│   │   │   ├── DoctorTable.tsx
│   │   │   └── PatientTable.tsx
│   │   └── dashboard/           # Componentes do dashboard
│   │       ├── StatsCard.tsx
│   │       └── Charts.tsx
│   ├── pages/
│   │   ├── auth/
│   │   │   ├── login.tsx
│   │   │   └── forgot-password.tsx
│   │   ├── admin/
│   │   │   ├── specialties/
│   │   │   │   ├── index.tsx
│   │   │   │   ├── create.tsx
│   │   │   │   └── edit.tsx
│   │   │   ├── doctors/
│   │   │   ├── employees/
│   │   │   ├── patients/
│   │   │   ├── plans/
│   │   │   └── dashboard.tsx
│   │   ├── doctor/
│   │   │   ├── appointments/
│   │   │   ├── schedule/
│   │   │   ├── medical-reports/
│   │   │   └── payments.tsx
│   │   └── patient/
│   │       ├── appointments.tsx
│   │       └── medical-history.tsx
│   ├── services/
│   │   ├── api.ts               # Configuração Axios
│   │   ├── auth.service.ts
│   │   ├── specialty.service.ts
│   │   ├── doctor.service.ts
│   │   ├── patient.service.ts
│   │   ├── appointment.service.ts
│   │   ├── medical-report.service.ts
│   │   └── payment.service.ts
│   ├── hooks/
│   │   ├── useAuth.ts
│   │   ├── useSpecialties.ts
│   │   ├── useDoctors.ts
│   │   └── useAppointments.ts
│   ├── store/
│   │   ├── auth.store.ts        # Zustand ou Pinia
│   │   ├── user.store.ts
│   │   └── ui.store.ts
│   ├── types/
│   │   ├── api.ts               # Tipos da API
│   │   ├── models.ts
│   │   └── forms.ts
│   ├── utils/
│   │   ├── api-client.ts
│   │   ├── validators.ts
│   │   ├── formatters.ts
│   │   └── helpers.ts
│   ├── middleware/
│   │   └── auth.middleware.ts
│   ├── styles/
│   │   ├── globals.css
│   │   └── variables.css
│   ├── App.tsx
│   └── main.tsx
├── tests/
├── .env.example
├── tailwind.config.js
├── tsconfig.json
└── vite.config.ts
```

---

## 🔐 Fluxo de Autenticação

### 1. Login
- Formulário simples com email e senha
- POST `/login` → retorna token JWT
- Armazenar token no localStorage
- Redirecionar para dashboard

### 2. Proteção de Rotas
- Middleware que valida token
- Se expirado, redirecionar para login
- Interceptador Axios para adicionar token em todas as requisições

### 3. Logout
- Remover token do armazenamento
- Limpar estado da aplicação
- Redirecionar para login

### 4. Atualização de Senha
- Modal ou página dedicada
- Validar senha atual
- PUT `/users/{id}/password`

---

## 📄 Páginas e Features por Módulo

### 🔐 Módulo de Autenticação
**Páginas:**
- Login (`/auth/login`)
- Recuperação de Senha (`/auth/forgot-password`)

**Componentes:**
- LoginForm
- FormValidation
- ErrorMessage

---

### 📊 Dashboard / Home
**Rota:** `/dashboard`

**Features:**
- Resumo estatístico:
  - Total de pacientes
  - Agendamentos do dia
  - Médicos ativos
  - Pagamentos pendentes
- Agendamentos próximos
- Atividades recentes
- Gráficos de desempenho

---

### 👨‍⚕️ Gestão de Médicos
**Rotas:**
- `/admin/doctors` - Listar
- `/admin/doctors/create` - Criar
- `/admin/doctors/:id/edit` - Editar
- `/admin/doctors/:id` - Detalhes

**Features:**
- Tabela com filtros (especialidade, status)
- Criar novo médico
  - Nome, Email, CRM/Conselho
  - Especialidade
  - Foto
- Editar médico
- Deletar médico
- Visualizar agendamentos do médico
- Visualizar disponibilidade
- Visualizar relatórios de pagamento

---

### 🏥 Gestão de Pacientes
**Rotas:**
- `/admin/patients` - Listar
- `/admin/patients/create` - Criar
- `/admin/patients/:id/edit` - Editar
- `/admin/patients/:id` - Detalhes

**Features:**
- Tabela com filtros (data cadastro, plano)
- Criar novo paciente
  - Nome, Email, CPF, Data de Nascimento
  - Endereço, Telefone
  - Plano associado
- Editar informações
- Deletar paciente
- Visualizar histórico médico
- Histórico de agendamentos

---

### 👔 Gestão de Funcionários
**Rotas:**
- `/admin/employees` - Listar
- `/admin/employees/create` - Criar
- `/admin/employees/:id/edit` - Editar

**Features:**
- CRUD completo
- Cargo/Função
- Status (ativo/inativo)

---

### 📋 Gestão de Especialidades
**Rotas:**
- `/admin/specialties` - Listar
- `/admin/specialties/create` - Criar
- `/admin/specialties/:id/edit` - Editar

**Features:**
- CRUD simples
- Nome, Descrição
- Tabela com busca rápida

---

### 💳 Gestão de Planos
**Rotas:**
- `/admin/plans` - Listar
- `/admin/plans/create` - Criar
- `/admin/plans/:id/edit` - Editar

**Features:**
- CRUD de planos
- Nome, Descrição, Valor (opcional)
- Benefícios
- Ativo/Inativo

---

### 📅 Agendamentos
**Rotas:**
- `/doctor/appointments` - Lista do médico
- `/doctor/appointments/:id` - Detalhes
- `/doctor/appointments/create` - Agendar
- `/patient/appointments` - Histórico do paciente

**Features:**
- Agendamento por médico/especialidade
  - Seleção de médico
  - Seleção de paciente
  - Calendário interativo
  - Horários disponíveis
  - Confirmação
- Visualizar agendamentos
- Editar agendamento
  - Alterar data/hora
  - Cancelar
- Mudar status
  - Confirmado
  - Cancelado
  - Realizado
  - Não compareceu

---

### 🕐 Indisponibilidades
**Rotas:**
- `/doctor/unavailable-times` - Lista
- `/doctor/unavailable-times/create` - Criar
- `/doctor/unavailable-times/:id/edit` - Editar

**Features:**
- Criar horários indisponíveis
  - Data/hora inicial
  - Data/hora final
  - Motivo (folga, férias, etc)
- Gerenciar lista
- Editar indisponibilidades
- Deletar

---

### 📑 Prontuários / Relatórios Médicos
**Rotas:**
- `/doctor/medical-reports` - Criar
- `/doctor/appointments/:id/medical-report` - Relatório da consulta
- `/patient/medical-history` - Histórico do paciente

**Features:**
- Criar prontuário após consulta
  - Diagnóstico
  - Prescrição
  - Notas clínicas
  - CID (ICD-10)
  - Campos customizáveis por médico
- Editar prontuário
- Visualizar histórico médico do paciente
- Exportar/Imprimir prontuário (PDF)

---

### 💰 Pagamentos
**Rotas:**
- `/doctor/payments` - Histórico de pagamentos

**Features:**
- Listagem de pagamentos
- Filtros (período, status)
- Visualizar detalhes
- Exportar relatório

---

### ⚙️ Agenda do Médico
**Rotas:**
- `/doctor/schedule` - Ver agenda

**Features:**
- Visualização semanal/mensal
- Horários disponíveis
- Horários indisponíveis
- Agendamentos confirmados
- Drag-and-drop para redimencionamento (opcional)

---

## 🎨 Design e UX

### Paleta de Cores
- Primária: Azul (confiança, profissionalismo)
- Secundária: Verde (saúde, bem-estar)
- Destaque: Laranja/Vermelho (alertas, CTA)
- Neutras: Cinza, Branco

### Componentes Principais
- Header com navegação
- Sidebar com menu principal
- Tabelas com paginação e filtros
- Modais para confirmações
- Toasts para feedback
- Loading spinners
- Empty states customizados
- Breadcrumbs de navegação

### Responsividade
- Mobile: Sidebar colapsível, layout empilhado
- Tablet: Layout adaptativo
- Desktop: Tela cheia com sidebars

---

## 🔌 Integração com API

### Base URL
```
http://localhost:8000/api
```

### Headers Padrão
```
{
  "Authorization": "Bearer {token}",
  "Content-Type": "application/json",
  "Accept": "application/json"
}
```

### Exemplo de Serviço
```typescript
import axios from 'axios';

const API = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
});

// Interceptador de requisição
API.interceptors.request.use((config) => {
  const token = localStorage.getItem('token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Interceptador de erro
API.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      // Redirecionar para login
      window.location.href = '/auth/login';
    }
    return Promise.reject(error);
  }
);

export default API;
```

---

## 📋 Endpoints da API Disponíveis

```
POST   /login                                    # Autenticação
POST   /logout                                   # Logout
GET    /user                                     # Usuário atual

GET    /specialties                              # Listar
GET    /specialties/:id                          # Detalhe
POST   /specialties                              # Criar
PUT    /specialties/:id                          # Atualizar
DELETE /specialties/:id                          # Deletar

GET    /plans                                    # Listar
GET    /plans/:id                                # Detalhe
POST   /plans                                    # Criar
PUT    /plans/:id                                # Atualizar
DELETE /plans/:id                                # Deletar

GET    /doctors                                  # Listar
GET    /doctors/:id                              # Detalhe
POST   /doctors                                  # Criar
PUT    /doctors/:id                              # Atualizar
DELETE /doctors/:id                              # Deletar

GET    /employees                                # Listar
GET    /employees/:id                            # Detalhe
POST   /employees                                # Criar
PUT    /employees/:id                            # Atualizar
DELETE /employees/:id                            # Deletar

GET    /patients                                 # Listar
GET    /patients/:id                             # Detalhe
POST   /patients                                 # Criar
PUT    /patients/:id                             # Atualizar
DELETE /patients/:id                             # Deletar

GET    /doctors/:id/appointments                 # Agendamentos do médico
GET    /appointments/:id                         # Detalhe
POST   /doctors/:id/appointments                 # Criar
PATCH  /appointments/:id                         # Atualizar
DELETE /appointments/:id                         # Deletar
PUT    /appointments/:id/status                  # Mudar status

GET    /unavailable-times                        # Listar
GET    /unavailable-times/:id                    # Detalhe
POST   /doctors/:id/unavailable-times            # Criar
PUT    /unavailable-times/:id                    # Atualizar
DELETE /unavailable-times/:id                    # Deletar

GET    /doctors/:id/schedule                     # Agenda do médico

GET    /appointments/:id/medical-report          # Relatório
POST   /appointments/:id/medical-report          # Criar
PUT    /appointments/:id/medical-report          # Atualizar
DELETE /appointments/:id/medical-report          # Deletar

GET    /patients/:id/medical-history             # Histórico médico
POST   /medical-reports                          # Criar relatório

GET    /unit-adresses                            # Unidades
GET    /councils                                 # Conselhos (CRM, etc)
GET    /cids                                     # Diagnósticos ICD-10
GET    /doctors/:id/report-config                # Config prontuário
GET    /doctors/:id/payments                     # Pagamentos

PUT    /users/:id/password                       # Atualizar senha
```

---

## ✅ Checklist de Implementação

### Fase 1: Configuração Base
- [ ] Estrutura de projeto criada
- [ ] Dependências instaladas
- [ ] Configuração Tailwind + componentes
- [ ] Configuração Axios com interceptadores
- [ ] Setup de autenticação

### Fase 2: Autenticação e Layout
- [ ] Página de login
- [ ] Middleware de proteção
- [ ] Layout principal (Navbar + Sidebar)
- [ ] Logout
- [ ] Armazenamento de token

### Fase 3: CRUD Básicos
- [ ] Especialidades
- [ ] Planos
- [ ] Médicos
- [ ] Pacientes
- [ ] Funcionários

### Fase 4: Agendamentos
- [ ] Criar agendamento
- [ ] Listar agendamentos
- [ ] Editar agendamento
- [ ] Mudar status
- [ ] Calendário interativo

### Fase 5: Funcionalidades Avançadas
- [ ] Prontuários médicos
- [ ] Histórico do paciente
- [ ] Indisponibilidades
- [ ] Agenda do médico
- [ ] Relatórios

### Fase 6: Melhorias e Deploy
- [ ] Testes unitários
- [ ] Validação de formulários
- [ ] Error handling robusto
- [ ] Otimização de performance
- [ ] Deploy em produção

---

## 🚀 Próximas Etapas

1. **Iniciar o projeto:**
   ```bash
   npm create vite@latest frontend -- --template react-ts
   cd frontend
   npm install
   ```

2. **Instalar dependências principais:**
   ```bash
   npm install axios react-router-dom zustand react-query zod react-hook-form date-fns
   npm install -D tailwindcss postcss autoprefixer
   npx tailwindcss init -p
   ```

3. **Configurar variáveis de ambiente:**
   ```
   VITE_API_URL=http://localhost:8000/api
   ```

4. **Começar com a página de login**

5. **Implementar layout e componentes base**

6. **Conectar com a API**

---

## 📞 Suporte e Documentação

- **API**: `clava-api-postman.json`
- **Database**: Consulte migrations do projeto
- **Conventions**: Siga as convenções de nome do projeto

---

**Status**: Pronto para desenvolvimento  
**Última atualização**: 2026-05-15  
**Versão**: 1.0
