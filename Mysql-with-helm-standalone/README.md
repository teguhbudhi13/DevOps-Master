List of command to install this
You need helm installed first

```bash
helm repo add bitnami https://charts.bitnami.com/bitnami
helm repo update
helm upgrade --install mysql -f mysql-standalone.yaml bitnami/mysql
```


