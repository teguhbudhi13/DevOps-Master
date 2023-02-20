The goal is to deploy from the "Standardize Yaml for Kubernetes" repository. To do this, follow these steps:

1.	Create a Jenkins container that includes a kubeconfig file which allows it to access the remote cluster where you want to deploy. You can find more information on how to do this in the "Jenkins for Kubernetes" folder.
2.	Use Jenkins pipeline syntax to clone the repository from the Git source. This will allow you to retrieve the necessary files for deployment like image below.

![image](https://user-images.githubusercontent.com/50268422/220190060-45185e1a-9969-4aca-b1c1-61a703289735.png)


3.	Consider using an attached volume for caching images to optimize the build time. This is optional, but it's recommended because it can significantly speed up the process. By using a volume, you can store the image so that it doesn't need to be rebuilt every time a deployment is triggered.
4.	When building a Docker image, you will need to have the login credentials for the image registry (public or private) to which the image will be pushed. Knowing the username and password is essential to successfully authenticate and push the image to the desired registry.


By following these steps, you can efficiently deploy from the "Standardize Yaml for Kubernetes" repository using Jenkins and Kubernetes.




```bash

podTemplate(yaml: '''
apiVersion: v1
kind: Pod
metadata:
  name: docker
  labels:
    name: docker
spec:
  volumes:
      - name: dockerjenkins
        persistentVolumeClaim:
          claimName: dockerjenkins
  containers:
    - name: docker
      image: bentolor/docker-dind-awscli:dind
      resources:
          limits:
            cpu: 8
            memory: 16Gi
          requests:
            cpu: 2
            memory : 4Gi
      volumeMounts:
        - name: dockerjenkins
          mountPath: /tmp/
      args:
      - "--mtu=1450"
      securityContext:
        privileged: true
      env:
      - name: DOCKER_TLS_CERTDIR
        value: ""
''') {
    node(POD_LABEL) {
        stage('gitclone') {
        git branch: 'master', credentialsId: 'd76d69be-b4aa-4f20-bb50-106620afbd22', url: 'https://github.com/teguhbudhi13/DevOps-Master.git'
            }
        stage('docker build')
            container('docker') 
            {
            sh 'cd Standarize Yaml for Kubernetes'
            sh 'docker login example.harbor.com -u admin -p admin'
            sh 'docker build -t example.harbor.com/production/sample1 . && docker push example.harbor.com/production/sample1'
            }
    }
    }
pipeline {
  agent any
  stages {
    stage('rollout deployment') {
      steps {
            git branch: 'master', credentialsId: 'd76d69be-b4aa-4f20-bb50-106620afbd22', url: 'https://github.com/teguhbudhi13/DevOps-Master.git'
            sh 'cd Standarize Yaml for Kubernetes'
            sh 'kubectl apply -f Sample1 without PVC.yaml -n default'
            }
        }
    }
} 

```
