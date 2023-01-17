FROM jenkins/jenkins:lts
USER root
SHELL ["/bin/bash", "-c"]
RUN apt update
RUN apt install nano -y
RUN curl -LO "https://dl.k8s.io/release/$(curl -L -s https://dl.k8s.io/release/stable.txt)/bin/linux/amd64/kubectl"
RUN chmod +x ./kubectl
RUN mv ./kubectl /usr/local/bin/kubectl
COPY kubeconfig .
RUN mkdir root/.kube
RUN touch root/.kube/config
RUN cp kubeconfig $HOME/.kube/config
RUN cat $HOME/.kube/config