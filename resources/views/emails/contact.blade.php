@component('mail::message')
# Nova Lead | Private Office

Caro **Marco Moura**,

Recebeu uma nova solicitação de consultoria através do portal digital. Segue o perfil do potencial cliente:

@component('mail::table')
| Dado | Informação |
| :--- | :--- |
| **Nome** | {{ $data['name'] }} |
| **Email** | [{{ $data['email'] }}](mailto:{{ $data['email'] }}) |
| **Telefone** | {{ $data['phone'] ?? 'Não indicado' }} |
| **Motivo** | {{ $data['subject'] ?? 'Contacto Geral' }} |
@if(isset($data['goal']))
| **Objetivo** | {{ $data['goal'] }} |
@endif
@if(isset($data['timeline']))
| **Prazo** | {{ $data['timeline'] }} |
@endif
@endcomponent

### Mensagem / Notas:
@component('mail::panel')
"{{ $data['message'] ?? 'Sem mensagem adicional.' }}"
@endcomponent

@component('mail::button', ['url' => 'mailto:' . $data['email']])
Iniciar Conversa
@endcomponent

Cumprimentos,<br>
**Sistema Digital Marco Moura**
@endcomponent