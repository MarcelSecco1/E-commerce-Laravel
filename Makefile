default: env prepare up key-generate populate
	@echo "--> Seu espaço de desenvolvimento local está pronto!! http://localhost:8989"

.PHONY: env
env:
	@echo "--> Copiando arquivo de configuração .env..."
	@cp .env.example .env

.PHONY: prepare
prepare:
	@echo "--> Instalando as dependencias do composer..."
	@docker run --rm -v $(PWD):/app composer install

.PHONY: up
up:
	@echo "--> Iniciando os docker containers..."
	@docker compose up --force-recreate -d
	@docker compose exec app php artisan storage:link

.PHONY: key-generate
key-generate:
	@echo "--> Gerando a key do laravel..."
	@docker compose exec app php artisan key:generate

.PHONY: populate
populate:
	@echo "--> Limpando e criando todas as tabelas..."
	@docker compose exec app php artisan migrate:fresh --seed

.PHONY:	down
down:
	@echo "--> Parando os docker containers..."
	@docker compose down

.PHONY:	restart
restart:	down up

.PHONY:	play
play:
	@docker compose exec app php artisan play

.PHONY: clear
clear:
	@echo "--> Limpando todas as coisas..."
	@docker compose exec app php artisan cache:clear
	@docker compose exec app php artisan config:clear
	@docker compose exec app php artisan route:clear
	@docker compose exec app php artisan view:clear
	@docker compose exec app php artisan optimize:clear
	@docker compose exec app php artisan optimize
	@echo "--> Terminamos..."

# .PHONY: update
# update:
# 	@read -p "Digite a mensagem do commit: " mensagem; \
# 	@git commit -a -m "$$mensagem"; \
# 	@git push origin main
# 	@echo "--> Enviado ao git com sucesso..."