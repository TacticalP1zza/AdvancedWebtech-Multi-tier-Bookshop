<!DOCTYPE html>
<html lang="en">

<title>Composing React Components</title>
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src= "https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<body>

<div id="root"></div>

<script type="text/babel">
function Intro(properties) {
  return <h1>Learn Module: {properties.learn}</h1>;
}

function AppFirst() {
  return (
    <div>
      <Intro learn="Web Technologies" />
      <Intro learn="Computational Intelligence I" />
      <Intro learn="Computational Intelligence II" />
	  <Intro learn="Advance Web Technologies" />
    </div>
  );
}

ReactDOM.render(<AppFirst />, document.getElementById('root'));
</script>

</body>
</html>