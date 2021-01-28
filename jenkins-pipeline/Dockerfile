FROM jenkins/jenkins

USER root

# Install ansible
RUN curl "https://bootstrap.pypa.io/get-pip.py" -o "get-pip.py" && python get-pip.py

RUN pip install -U ansible

# Install Docker

RUN  apt-get update && \
apt-get -y install apt-transport-https \
     ca-certificates \
     curl \
     gnupg2 
RUN DEBIAN_FRONTEND=noninteractive apt-get -y install software-properties-common
#software-properties-common
RUN curl -fsSL https://download.docker.com/linux/debian/gpg | apt-key add - 
RUN add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/debian $(lsb_release -cs) stable" 
RUN apt-get update 
RUN apt-get -y install docker-ce

# COmpose

RUN curl -L "https://github.com/docker/compose/releases/download/1.22.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose && chmod +x /usr/local/bin/docker-compose

#RUN usermod -aG docker jenkins

USER root
#RUN if [ -e /var/run/docker.sock ]; then chown jenkins:jenkins /var/run/docker.sock; fi
#USER jenkins
