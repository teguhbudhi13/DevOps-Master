Access to your MySQL server first and run this command below

```bash
CREATE DATABASE test_db;
USE test_db;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL
);
```

Create Docker Image from source code above
Change the mysql detail on app.js with your host,port,username, and password based on your MySQL server
Here is the example if push the docker hub teguhbudhi13/crudapi:latest

```bash
docker build -t teguhbudhi13/crudapi:latest .
docker push teguhbudhi13/crudapi:latest
```

To deploy in kubernetes change the parameter you want in crudapi.yaml like image name, ingress class, and host you want to publish
```bash
kubectl apply -f crudapi.yaml
```
Note: This is just an example, you need to replace your_docker_image with your actual Docker image and api.example.com with your desired domain name. Also, make sure you have set up cert-manager and have a cluster issuer named letsencrypt-prod before deploying this YAML file.


This is the detail if you want to test all of the CRUD operation

Read Users based on id 
```bash
curl -X GET https://api.example.com/user/1
```

Create New user with increment id
```bash
curl -X POST \
  https://api.example.com/user \
  -H 'Content-Type: application/json' \
  -d '{
    "name": "John Doe",
    "email": "john.doe@example.com"
}'
```

Update existing user with specific id example with user id 1
```bash
curl -X PUT \
  https://api.example.com/user/1 \
  -H 'Content-Type: application/json' \
  -d '{
    "name": "Jane Doe",
    "email": "jane.doe@example.com"
}'
```

Delete specific user id
```bash
curl -X DELETE https://api.example.com/user/1
```