FROM ubuntu
RUN apt-get update && apt-get install -y python3-pip libssl-dev && pip3 install bigchaindb==2.0.0a6 &&  apt-get install -y mongodb
RUN apt-get install -y unzip && apt-get install -y wget && wget https://github.com/tendermint/tendermint/releases/download/v0.19.3/tendermint_0.19.3_linux_amd64.zip
RUN unzip tendermint_0.19.3_linux_amd64.zip && rm tendermint_0.19.3_linux_amd64.zip && mv tendermint /usr/local/bin
RUN apt-get install -y ufw && apt-get install -y sudo && apt-get install vim && useradd -m docker && echo "docker:docker" | chpasswd && adduser docker sudo 
RUN  echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers
# RUN bigchaindb configure && tendermint init && tendermint show_node_id

# docker run -d -p 7984:7984 --name practical_turing3 t1 tail -f /dev/null
# docker exec -it practical_turing3 mkdir -p /data/db
# docker exec -it practical_turing3 mongod
# docker exec -it -d practical_turing3 tendermint init
# docker exec -it --privileged  practical_turing3 ufw allow 22/tcp
# docker exec -it --privileged  practical_turing3 ufw allow 7894/tcp
# docker exec -it --privileged  practical_turing3 ufw allow 7985/tcp
# docker exec -it --privileged  practical_turing3 ufw allow 46656/tcp
# docker exec -it --privileged  practical_turing cat /root/.tendermint/config/priv_validator.json
    

# docker run -d -p 6984:6984 --name coordinator t1 tail -f /dev/null
# docker run -d -p 7984:7984 --name member1 t1 tail -f /dev/null
# docker run -d -p 8984:8984 --name member2 t1 tail -f /dev/null
# docker run -d -p 9984:9984 --name member3 t1 tail -f /dev/null
# docker exec -it coordinator mkdir -p /data/db
# docker exec -it member1 mkdir -p /data/db
# docker exec -it member2 mkdir -p /data/db
# docker exec -it member3 mkdir -p /data/db
# docker exec -it -d coordinator mongod
# docker exec -it -d member1 mongod
# docker exec -it -d member2 mongod
# docker exec -it -d member3 mongod
# docker exec -it  coordinator tendermint init
# docker exec -it  member1 tendermint init
# docker exec -it  member2 tendermint init
# docker exec -it  member3 tendermint init
# docker exec -it --privileged  coordinator ufw allow 22/tcp
# docker exec -it --privileged  member1 ufw allow 22/tcp
# docker exec -it --privileged  member2 ufw allow 22/tcp
# docker exec -it --privileged  member3 ufw allow 22/tcp
# docker exec -it --privileged  coordinator ufw allow 46656/tcp
# docker exec -it --privileged  member1 ufw allow 46656/tcp
# docker exec -it --privileged  member2 ufw allow 46656/tcp
# docker exec -it --privileged  member3 ufw allow 46656/tcp
# docker exec -it --privileged  coordinator ufw allow 6894/tcp
# docker exec -it --privileged  coordinator ufw allow 6895/tcp
# docker exec -it --privileged  member1 ufw allow 7984/tcp
# docker exec -it --privileged  member1 ufw allow 7985/tcp
# docker exec -it --privileged  member2 ufw allow 8984/tcp
# docker exec -it --privileged  member2 ufw allow 8985/tcp
# docker exec -it --privileged  member3 ufw allow 9984/tcp
# docker exec -it --privileged  member3 ufw allow 9985/tcp
# docker exec -it -d coordinator tendermint node 
# docker exec -it -d member1 tendermint node 
# docker exec -it -d member2 tendermint node 
# docker exec -it -d member3 tendermint node 
# docker exec -it coordinator bigchaindb configure
# docker exec -it member1 bigchaindb configure
# docker exec -it member2 bigchaindb configure
# docker exec -it member3 bigchaindb configure
# docker exec -it coordinator bigchaindb start
# docker exec -it member1 bigchaindb start
# docker exec -it member2 bigchaindb start
# docker exec -it member3 bigchaindb start
# docker exec -it member1 cat /root/.tendermint/config/priv_validator.json
# docker exec -it coordinator tendermint show_node_id
# docker exec -it member1 tendermint show_node_id
# docker exec -it member2 tendermint show_node_id
# docker exec -it member3 tendermint show_node_id
# docker exec -it coordinator cat /root/.tendermint/config/genesis.json
# docker exec -it coordinator vim /root/.tendermint/config/config.toml
# Coordinator - c6900097dcdafe361498f2297d7a28235b1b71fd
# {
#   "address": "0CDB58C0E42BF91545EE2E707E1ABB98FB4FDA46",
#   "pub_key": {
#     "type": "AC26791624DE60",
#     "value": "lEOWu+U4F3sTs/JaHFPuWDjTLaD8YUZwICDqFxQmlYM="
#   },
#   "last_height": 0,
#   "last_round": 0,
#   "last_step": 0,
#   "priv_key": {
#     "type": "954568A3288910",
#     "value": "bQ7+/zuS6iMoA+PoZ86x1lihOQu73I6SfbOeR5Q/+lGUQ5a75TgXexOz8locU+5YONMtoPxhRnAgIOoXFCaVgw=="
#   }
# }

# Member 1 - ea11d7ae9e214aeb0406ddb5451e4bd6028c1a1f
# {
#   "address": "42A981D5A96F52A95356098D023C2BC41B72317C",
#   "pub_key": {
#     "type": "AC26791624DE60",
#     "value": "yfGrOd9pFkU/sHqNI1YXg454G/uwPK8ZeKzr0DKO5LU="
#   },
#   "last_height": 0,
#   "last_round": 0,
#   "last_step": 0,
#   "priv_key": {
#     "type": "954568A3288910",
#     "value": "TB+8p9ogxrqe68rxF0A/iD7BZVTjQuS+w3I0KpZD/N7J8as532kWRT+weo0jVheDjngb+7A8rxl4rOvQMo7ktQ=="
#   }



 
#  Member 2 - 7d898e02cc763d3838e225046b8eaeb2e2e9a58a
# {
#   "address": "35FD43258E9F45F71C801325E5496105ADB29E00",
#   "pub_key": {
#     "type": "AC26791624DE60",
#     "value": "2rYHqD4ej1/JMUjMyTzPQ9VZdYt8QS1QEJqyF1lDvxM="
#   },
#   "last_height": 0,
#   "last_round": 0,
#   "last_step": 0,
#   "priv_key": {
#     "type": "954568A3288910",
#     "value": "9SbDkhX8XF0i7v7ndEt7hJc56HC5OFRK6VwAY9XOnYLatgeoPh6PX8kxSMzJPM9D1Vl1i3xBLVAQmrIXWUO/Ew=="
#   }
# }



# Member 3 - edf841e1121e202eb67657670b23366002b61d87
# {
#   "address": "EBA77CA96E2559201F325650A5E76D33F4E58434",
#   "pub_key": {
#     "type": "AC26791624DE60",
#     "value": "UJa/sxb7k+hOYp7TRkOk1J1icPfgDwsC+ntqsYM+HSU="
#   },
#   "last_height": 0,
#   "last_round": 0,
#   "last_step": 0,
#   "priv_key": {
#     "type": "954568A3288910",
#     "value": "qyoxcAmbCCVDSGjt0MQ9Nb1phKf6ShW52sQlogTqHUNQlr+zFvuT6E5intNGQ6TUnWJw9+APCwL6e2qxgz4dJQ=="
#   }
# }

# {
#   "genesis_time": "2018-05-30T09:39:01.0317323Z",
#   "chain_id": "test-chain-6o5DQo",
#   "validators": [
#     {
#       "pub_key": {
#         "type": "AC26791624DE60",
#         "value": "lEOWu+U4F3sTs/JaHFPuWDjTLaD8YUZwICDqFxQmlYM="
#       },
#       "power": 10,
#       "name": "coordinator"
#     },
#      {
#       "pub_key": {
#         "type": "AC26791624DE60",
#         "value": "yfGrOd9pFkU/sHqNI1YXg454G/uwPK8ZeKzr0DKO5LU="
#       },
#       "power": 10,
#       "name": "member1"
#     },
#      {
#       "pub_key": {
#         "type": "AC26791624DE60",
#         "value": "2rYHqD4ej1/JMUjMyTzPQ9VZdYt8QS1QEJqyF1lDvxM="
#       },
#       "power": 10,
#       "name": "member2"
#     },
#      {
#       "pub_key": {
#         "type": "AC26791624DE60",
#         "value": "UJa/sxb7k+hOYp7TRkOk1J1icPfgDwsC+ntqsYM+HSU="
#       },
#       "power": 10,
#       "name": "member3"
#     }
#   ],
#   "app_hash": ""
# }



# persistent_peers = "c6900097dcdafe361498f2297d7a28235b1b71fd@172.17.0.2:46656,ea11d7ae9e214aeb0406ddb5451e4bd6028c1a1f@172.17.0.3:46656,7d898e02cc763d3838e225046b8eaeb2e2e9a58a@172.17.0.4:46656,edf841e1121e202eb67657670b23366002b61d87@172.17.0.5:46656"
