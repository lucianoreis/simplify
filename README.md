# Simplify Pagamentos


### Instalando o projeto
```bash
$ git clone git@github.com:lucianoreis/simplify.git
```
```bash
$ composer install
```
### Gerar tabelas no banco de dados
Crie um banco de dados e configure os dados de conexão em `config/autload/doctrine.local.php` depois execute o comando a baixo para gerar as telas.

```bash
php vendor/bin/doctrine orm:schema-tool:update --force`.
```

### Criar usuários

```bash
$ php new_user.php Luciano 11111111 luciano@teste.com 123 false 500.60
```
