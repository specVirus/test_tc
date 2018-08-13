FROM iwaydev/base-php-console-7.1-dev

WORKDIR /var/www/yii2-iway-template

CMD ["php", "./yii", "sample-daemon/index"]
HEALTHCHECK CMD ps -aux | grep "[p]hp ./yii sample-daemon" || exit 1
