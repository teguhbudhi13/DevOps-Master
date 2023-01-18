You need install helm first to install this first

```bash
kubectl create namespace ingress-nginx
helm upgrade --install ingress-nginx -n ingress-nginx ingress-nginx/ingress-nginx -f ingress-nginx.yaml
```