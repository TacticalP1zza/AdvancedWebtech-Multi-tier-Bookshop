<!DOCTYPE html>
<html lang="en">

<title>Clock Using React</title>
<!-- REACT is JavaScript library created by Facebook used for building Web App -->
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

<body>
<div id="root"></div>
<h1> Present time (using REACT): </h1>
<p id="presentTime"></p>

<script type="text/babel">
function tick() {
  const element = (<h1>{new Date().toLocaleTimeString()}</h1>);
  ReactDOM.render(element, document.getElementById('presentTime'));
}

//setInterval(tick,10000);
setInterval(tick,1000); 
</script>

</body>
</html>