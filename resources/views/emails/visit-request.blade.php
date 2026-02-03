<!DOCTYPE html>
<html>
<head>
    <title>Solicitação de Visita</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-w-600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px;">
        <h2 style="color: #c9a35e;">Novo Interesse de Visita</h2>
        
        <p>Olá,</p>
        <p>Você recebeu uma nova solicitação de agendamento para o imóvel: <strong>{{ $property->title }}</strong></p>
        
        <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <h3 style="margin-top: 0;">Dados do Cliente</h3>
            <p><strong>Nome:</strong> {{ $data['name'] }}</p>
            <p><strong>Email:</strong> {{ $data['email'] }}</p>
            <p><strong>Telefone:</strong> {{ $data['phone'] }}</p>
            <p><strong>Data/Hora Preferencial:</strong> {{ $data['preferred_date'] }}</p>
        </div>

        @if(!empty($data['message']))
            <div style="margin-bottom: 20px;">
                <strong>Mensagem do Cliente:</strong><br>
                <p style="font-style: italic;">"{{ $data['message'] }}"</p>
            </div>
        @endif

        <p>Entre em contato com o cliente o mais breve possível.</p>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="font-size: 12px; color: #999;">Email enviado automaticamente pelo sistema Crow Global.</p>
    </div>
</body>
</html>