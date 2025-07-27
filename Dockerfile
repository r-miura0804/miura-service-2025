FROM php:8.3-fpm-alpine

# 必要なシステムパッケージをインストールします。
# git: バージョン管理用 (コンテナ内でgit cloneなど行う場合に必要)
# zip, unzip: Composerの依存関係インストールなどで必要
# nodejs, npm: フロントエンドのアセットビルド (Laravel Mix/Viteなど) で必要になる可能性
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    nodejs \
    npm \
    mysql-client # MySQLクライアント (コンテナ内からDBに接続テストする際に便利)

# Composerをインストールします。
# composer:latest イメージから/usr/bin/composerをコピーします。
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHPの拡張機能をインストールします。
# pdo_mysql: MySQLデータベースに接続するために必要
# opcache: PHPのパフォーマンス最適化
RUN docker-php-ext-install pdo_mysql opcache

# タイムゾーンを設定します (日本時間に設定)。
ENV TZ Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# アプリケーションの作業ディレクトリを設定します。
WORKDIR /var/www/html