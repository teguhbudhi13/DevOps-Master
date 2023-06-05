You need install helm first to install this first

```bash
kubectl create namespace ingress-nginx
helm repo add ingress-nginx https://kubernetes.github.io/ingress-nginx/
helm repo update
helm upgrade --install ingress-nginx -n ingress-nginx ingress-nginx/ingress-nginx -f ingress-nginx.yaml
```
