#!/bin/sh

COLOR_GREEN='\033[0;32m'
COLOR_RED='\033[0;31m'
COLOR_YELLOW='\033[0;33m'
COLOR_RESET='\033[0m'

# Проверка на root'а
if [ $(id -u) = 0 ]; then
  echo "${COLOR_RED}Вы root. Выполните команду не от root'а.${COLOR_RESET}"
  exit
fi

WORK_DIR=$1
USER=$(whoami)
HOST_IP=$(hostname  -I | cut -f1 -d' ')
STACK_FILE="stack.${USER}.yml"

deploy () {
echo "\r\n${COLOR_YELLOW}Начинаю деплой: ${STACK_FILE} ${COLOR_RESET}"
sudo docker-compose -f ${STACK_FILE} up -d
echo "\r\n${COLOR_GREEN}Готово ${COLOR_RESET}"
}

cd ${WORK_DIR}

if [ -f ${STACK_FILE} ]; then
    echo "\r\n${COLOR_YELLOW}Найден стек ${STACK_FILE} ${COLOR_RESET}"
    deploy
    exit
fi

if [ ! -f "stack.example.yml" ]; then
    echo "\r\n${COLOR_RED} Error: stack.example.yml не найден ${COLOR_RESET}"
    exit
fi

cp stack.example.yml ${STACK_FILE}
sed -i 's/{{IP_ADDRESS}}/'$HOST_IP'/' ${STACK_FILE}

echo "\r\n${COLOR_GREEN}Создан персональный конфиг: ${STACK_FILE} ${COLOR_RESET}"
deploy