<h2>Nova Candidatura Recebida</h2>
<p><strong>Nome:</strong> {{ $data['name'] }}</p>
<p><strong>E-mail:</strong> {{ $data['email'] }}</p>
<p><strong>Telefone:</strong> {{ $data['phone'] }}</p>
<p><strong>Mensagem:</strong></p>
<p>{{ $data['message'] ?? 'Sem mensagem adicional.' }}</p>