The both file above is for deploy and publish pod to this parameter so make sure to edit with your requirement

1. Deployment name is sample1
2. Image used is which is private example.harbor.com/production/sample1
3. The Port that exposed in that docker image is 3001
4. The url that will be published and used is sample1.example.com

To create image pull secret that can be used for private image use this command and change it with your own configuration


```bash
kubectl create secret docker-registry pull-secret --docker-server=example.harbor.com --docker-username=admin --docker-password=admin
```