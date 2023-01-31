const express = require('express');
const app = express();
const port = 3000;
const mysql = require('mysql');

const connection = mysql.createConnection({
  host: 'localhost',
  port: 3306,
  user: 'root',
  password: 'password',
  database: 'test_db'
});

app.use(express.json());

app.post('/user', (req, res) => {
  const { name, email } = req.body;
  connection.query('INSERT INTO users SET ?', { name, email }, (error, result) => {
    if (error) throw error;
    res.status(201).send(`User added with ID: ${result.insertId}`);
  });
});

app.get('/user/:id', (req, res) => {
  const { id } = req.params;
  connection.query('SELECT * FROM users WHERE id = ?', [id], (error, result) => {
    if (error) throw error;
    res.send(result);
  });
});

app.put('/user/:id', (req, res) => {
  const { id } = req.params;
  const { name, email } = req.body;
  connection.query('UPDATE users SET name = ?, email = ? WHERE id = ?', [name, email, id], (error, result) => {
    if (error) throw error;
    res.send(`User modified with ID: ${id}`);
  });
});

app.delete('/user/:id', (req, res) => {
  const { id } = req.params;
  connection.query('DELETE FROM users WHERE id = ?', [id], (error, result) => {
    if (error) throw error;
    res.send(`User deleted with ID: ${id}`);
  });
});

app.use((req, res) => {
  res.status(404).send({ message: 'Endpoint not found' });
});

app.listen(port, () => {
  console.log(`API running on port ${port}`);
});
