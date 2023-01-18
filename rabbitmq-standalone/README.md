List of command to install this
You need helm installed first

```bash
helm upgrade --install rabbitmq bitnami/rabbitmq -f rabbitmqstandalone.yaml
kubectl apply -f rabbitmqui.yaml
```

after install this you must forward it to ingress-nginx tcp forward for service in port 5672 so service can consume rabbitmq api