<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>
    <table>
      <tr>
        <th>Name</th>
        <th>{{ $data['fullName'] ?? NULL }}</th>
       
      </tr>
      <tr>
        <td>Cover Letter</td>
        <td>{{ $data['cover_letter'] ?? NULL }}</td>
      </tr>
         <tr>
        <td>Salary</td>
        <td>{{ $data['salary'] ?? NULL }}</td>
      </tr>
    </table>

</body>
</html>