List of command to install this
You need helm installed first

```bash
helm repo add bitnami https://charts.bitnami.com/bitnami
helm repo update
helm upgrade --install postgress -f helm-postgress.yaml bitnami/postgresql
```

after install this you must forward it to ingress-nginx tcp forward
