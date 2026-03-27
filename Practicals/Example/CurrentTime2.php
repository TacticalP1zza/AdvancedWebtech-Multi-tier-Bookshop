<!DOCTYPE html>
<html lang="en">

<title>Clock Using React</title>
<!-- REACT is JavaScript library created by Facebook used for building Web App -->
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

<body>
<div id="root"></div>
<h1> Present time (using REACT), now encapsulated: </h1>
<p id="presentTime"></p>

<script type="text/babel">
function Clock(props) {
  return (
    <div>
      <h2>Current time is {props.date.toLocaleTimeString()}.</h2>
    </div>
  );
}

function tick() {
  ReactDOM.render(
    <Clock date={new Date()} />,
    document.getElementById('presentTime')
  );
}


setInterval(tick,1000); 
</script>

</body>
</html>