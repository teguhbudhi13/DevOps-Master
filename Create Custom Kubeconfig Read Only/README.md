```markdown
# Custom Kubeconfig Tutorial

In this tutorial, our goal is to create an additional kubeconfig file with specific privileges. We aim to provide a user with read-only privileges or read, write, and update privileges, while preventing them from deleting any resources. The purpose of this configuration is to allow the user to monitor the cluster effectively while minimizing the potential for any harmful actions that could impact the cluster's operation.

By following the steps outlined in this tutorial, you will be able to create a customized kubeconfig file that grants the desired level of access, ensuring that the user has the necessary visibility into the cluster without compromising its stability.

## Step 1: Choose the desired kubeconfig file

If you want to create a user with read-only privileges, use the following command:

```bash
kube-read-cluster-role.yaml
```

If you want to create a user with read, write, and update privileges (without the ability to delete resources), use the following command:

```bash
kube-readandwrite-cluster-role.yaml
```

## Step 2: Generate a certificate request and create a certificate signing request (CSR)

Generate the certificate request and create the CSR using the following commands:

```bash
openssl req -new -newkey rsa:4096 -nodes -keyout kube-support.key -out kube-support.csr -subj "/CN=kube-support/O=readers"
sed -i "s/request: csr/request: $(cat kube-support.csr | base64 | tr -d '\n')/" kube-support-csr.yaml
kubectl apply -f kube-support-csr.yaml
```

## Step 3: Approve the CSR

Check the CSR status to ensure it is pending:

```bash
kubectl get csr
```

Approve the CSR using the following command:

```bash
kubectl certificate approve kube-support-reader-access
```

Make sure the CSR status changes to "Approved" or "Issued" before proceeding to the next step:

```bash
kubectl get csr
```

And later we can retrieve the certificate (crt) with the following command:

```bash
kubectl get csr kube-support-reader-access -o jsonpath='{.status.certificate}' | base64 --decode > kube-support.crt
```

## Step 4: Generate the kubeconfig file

Execute the following commands to generate the kubeconfig file named kube-support-config:

```bash
kubectl config view -o jsonpath='{.clusters[0].cluster.certificate-authority-data}' --raw | base64 --decode - > k8s-ca.crt

kubectl config set-cluster $(kubectl config view -o jsonpath='{.clusters[0].name}') --server=$(kubectl config view -o jsonpath='{.clusters[0].cluster.server}') --certificate-authority=k8s-ca.crt --kubeconfig=kube-support-config --embed-certs

kubectl config set-credentials kube-support --client-certificate=kube-support.crt --client-key=kube-support.key --embed-certs --kubeconfig=kube-support-config

kubectl config set-context default --cluster=$(kubectl config view -o jsonpath='{.clusters[0].name}') --namespace=default --user=kube-support --kubeconfig=kube-support-config

kubectl config use-context default --kubeconfig=kube-support-config
```

## Step 5: Verify the kubeconfig works

Check if the kubeconfig is functioning correctly using the following command:

```bash
kubectl --kubeconfig kube-support-config get pods -A
```

Note: You may encounter an error like the one shown below:

```
Error from server (Forbidden): pods is forbidden: User "kube-support" cannot list resource "pods" in API group "" in the namespace "default

"
```

## Step 6: Bind the user to the appropriate role

To resolve the error, bind the kube-support user to the kube-reader-cluster-role using the following command:

```bash
kubectl create clusterrolebinding kube-support-kube-reader --clusterrole=kube-reader-cluster-role --user=kube-support
```

Now, try the command from Step 5 again; it should work without any errors:

```bash
kubectl --kubeconfig kube-support-config get pods -A
```

## Step 7: Test the kubeconfig with deployment creation and deletion

First, deploy a sample deployment using the following command:

```bash
kubectl --kubeconfig kube-support-config create deployment web-server --image=nginx
```

Next, attempt to delete the deployment using the kubeconfig file with the following command:

```bash
kubectl --kubeconfig kube-support-config delete deployment web-server
```

You should receive an error message similar to the one below:

```
Error from server (Forbidden): deployments.apps "web-server" is forbidden: User "kube-support" cannot delete resource "deployments" in API group "apps" in the namespace "default"
```

Congratulations! You now have an additional kubeconfig file with customized privileges.

By following these steps, you will be able to generate the kubeconfig file and test its functionality, ensuring that the user has the appropriate level of access and restrictions within the Kubernetes cluster.
```

Feel free to copy and paste this modified version into your README.md file on GitHub, making it easier for users to understand and follow the tutorial.