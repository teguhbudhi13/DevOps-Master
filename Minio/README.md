Before you install the Minio, you need to change the value in the miniovalues.yaml file as follows:

1. Check the cluster issuer name that is installed on your Kubernetes system for both the API and console, and update it accordingly.
2. Change the root password (by default the username is "admin").
3. Change the image tag if you want to install a specified version.
4. If the values use an empty existing PVC, delete the line if you don't want to use existing PVC.
5. Change the resource limit and request depending on your needs.
6. After that you can install with command below

```bash
helm upgrade --install miniodev bitnami/mninio -f minivalues.yaml
```