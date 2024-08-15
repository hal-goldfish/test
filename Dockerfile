
FROM sail-8.3/app

# 必要なパッケージをインストール
RUN apt-get update && \
    apt-get install -y python3 python3-pip

# Python の依存パッケージをインストール（必要に応じて）
RUN pip3 install --upgrade pip
