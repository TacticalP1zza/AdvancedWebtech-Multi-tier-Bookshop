<!DOCTYPE html>
<html lang="en">
<title>JSX Expressions</title>
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

<body>
<div id="tag001"></div>

<script type="text/babel">
const FirstName = 'Bappaditya';

ReactDOM.render(
  <h1>Hello {FirstName}</h1>, document.getElementById('tag001'));
</script>

</body>
</html>