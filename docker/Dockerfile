FROM ubuntu
RUN apt-get update && apt-get install -y python3-pip libssl-dev && pip3 install bigchaindb==2.0.0a6 &&  apt-get install -y mongodb
RUN apt-get install -y unzip && apt-get install -y wget && wget https://github.com/tendermint/tendermint/releases/download/v0.19.3/tendermint_0.19.3_linux_amd64.zip
RUN unzip tendermint_0.19.3_linux_amd64.zip && rm tendermint_0.19.3_linux_amd64.zip && mv tendermint /usr/local/bin
RUN apt-get install -y ufw && apt-get install -y sudo && useradd -m docker && echo "docker:docker" | chpasswd && adduser docker sudo 
RUN  echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
ENV BIGCHAINDB_DATABASE_BACKEND: localmongodb
ENV BIGCHAINDB_DATABASE_HOST: mongodb
ENV BIGCHAINDB_DATABASE_PORT: 27017
ENV BIGCHAINDB_SERVER_BIND: 0.0.0.0:9984
ENV BIGCHAINDB_WSSERVER_HOST: 0.0.0.0
ENV BIGCHAINDB_WSSERVER_ADVERTISED_HOST: bigchaindb
ENV BIGCHAINDB_TENDERMINT_HOST: tendermint
ENV BIGCHAINDB_TENDERMINT_PORT: 46657
# RUN bigchaindb configure && tendermint init && tendermint show_node_id

#docker run t1 tail -f /dev/null
#mkdir -p /data/db
#mongod