<x-mail::message>
  # L'utente {{ $formData["name"] }} ti ha contattato!

  Email: {{ $formData["email"] }} <br>
  Messaggio: {{ $formData["message"] }}
</x-mail::message>