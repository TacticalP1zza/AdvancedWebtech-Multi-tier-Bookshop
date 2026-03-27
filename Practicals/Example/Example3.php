<!DOCTYPE html>
<html lang="en">

<title>React Components</title>
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src= "https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<body>

<div id="root"></div>

<script type="text/babel">
function Introduction() {
  return <h1>Demonstrating React Components!</h1>;
}

ReactDOM.render(<Introduction />, document.getElementById('root'));
</script>

</body>
</html>