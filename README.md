
# Api de administração de clientes - KaBuM

Api com arquitetura hexagonal, pensada em duas fronteiras principais:
dataProviders - Tudo que é fornecido por agenets externos, ou seja, uma api de integração, um banco de dado de integração dentre outros. E Entrypoints - que são os dados que são fornecidos por esta api e sua estrutura de camadas. Foi desenvolvida em PHP.


## Instalação

Faça o clone no git

```bash
  git glone https://github.com/davidrlmagallhaes/api-administracao-clientes.git
```
Acesse o diretório do projeto

```bash
  cd ./api-administracao-clientes
``` 
Instale a denpendencia do composer

```bash
  composer install
```     
Instale o ambiente docker

```bash
  cd ./api-administracao-clientes/src/entrypoints/infrastructures/docker
  sudo docker-compose up
```   

A porta está estabelecida para http://localhost:8000

## Execução dos testes

Realizando testes de use cases

```bash
  phpunit tests/usecases/AdicionarClienteUseCaseTest.php
  phpunit tests/usecases/EditarClienteUseCaseTest.php
  phpunit tests/usecases/listarClienteUseCaseTest.php
  phpunit tests/usecases/ObterClientePorIdUseCaseTest.php
  phpunit tests/usecases/DeletarClienteUseCaseTest.php
```
Realizando testes de services

```bash
  phpunit tests/services/ClienteServiceTest.php
```
Realizando testes de services

```bash
  phpunit tests/services/ClienteServiceTest.php
```
Realizando testes de resources

```bash
  phpunit tests/resources/ClienteResourceTest.php
```
## Estrutura do projeto

  Segue a arquitetura hexagonal

```bash
└── src
    └──  dataproviders
	└──  entrypoints
		└──  domain
		└──  entities
			└──  Cliente.php
			└──  Endereco.php
			└──  Usuario.php
		└──  getways
			└──  ClienteGetway.php
		└──  repositories
		└──  infraestructures
			└── dao
				└──  ClienteDAO.php
				└──  UsuarioDAO.php
			└── docker
				└──  entrypoints
				└──  docker-compose.yml
	└──  ClienteResource.php
    └──  services
        └── ClienteService.php
	└──  usecases
        └── AdicionarClienteUseCase.php
		└── DeletarClienteUseCase.php
		└── EditarClienteUseCase.php
		└── ListarClienteUseCase.php
		└── ObterClienteUseCase.php
	└──  tests
		└── resources
		└── services
		└── usecases
	└── index.php
  
```



## Documentação da API

#### Retorna todos os clientes

```http
  GET /cliente
```

#### Retorna o cliente por ID


```http
  GET /cliente/${id}
```

| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `id`      | `integer` | **Obrigatório**. O ID do cliente que você quer |

#### Adicionar um cliente

```http
  POST /cliente/cadastro
  Content-Type: application/json
```
| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `nome`      | `string` | **Obrigatório**.|
| `cpf`      | `string` | **Obrigatório**. |
| `rg`      | `string` | **Obrigatório**.  |
| `dataNascimento`      | `string` | **Obrigatório**. |
| `telefone`      | `string` | **Obrigatório**.  |
| `enderecos`      | `array` | **Obrigatório**.  |
| `cep`      | `string` | **Obrigatório**.  |
| `numero`      | `string` |  |
| `logradouro`      | `string` | **Obrigatório**.  |
| `complemento`      | `string` |   |
| `bairro`      | `string` | **Obrigatório**.  |
| `localidade`      | `string` | **Obrigatório**.  |
| `uf`      | `string` | **Obrigatório**.  |

#### Editar um cliente

```http
  PUT /cliente/${id}
  Content-Type: application/json
```
| Parâmetro   | Tipo       | Descrição                                   |
| :---------- | :--------- | :------------------------------------------ |
| `nome`      | `string` | **Obrigatório**.|
| `cpf`      | `string` | **Obrigatório**. |
| `rg`      | `string` | **Obrigatório**.  |
| `dataNascimento`      | `string` | **Obrigatório**. |
| `telefone`      | `string` | **Obrigatório**.  |
| `enderecos`      | `array` | **Obrigatório**.  |
| `id`      | `integer` | **Obrigatório**.  |
| `cep`      | `string` | **Obrigatório**.  |
| `numero`      | `string` |  |
| `logradouro`      | `string` | **Obrigatório**.  |
| `complemento`      | `string` |   |
| `bairro`      | `string` | **Obrigatório**.  |
| `localidade`      | `string` | **Obrigatório**.  |
| `uf`      | `string` | **Obrigatório**.  |

#### Deletar um cliente

```http
  DELETE /cliente/${id}
  Content-Type: application/json
```
