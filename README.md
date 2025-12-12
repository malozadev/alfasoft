
# Contacts Management

### Login Padrão

- **Email:** admin@alfasoft.com  
- **Senha:** 123456

### Testers

- **Verifica se um visitante (não autenticado) pode acessar a lista de contatos**
-- php artisan test --filter "guest_can_view_contacts"

- **Verifica se um usuário autenticado pode criar um contato**
-- php artisan test --filter "authenticated_user_can_create_contact"

- **Verifica se os erros de validação são retornados quando dados inválidos são enviados**
-- php artisan test --filter "validation_errors_are_returned_when_adding_contact"
