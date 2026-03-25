<!DOCTYPE html>
<html lang="en">

<title>Clock Using React</title>
<!-- REACT is JavaScript library created by Facebook used for building Web App -->
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

<body>
<h1> Present time using four clocks (using REACT) encapsulated in class form with local state and life cycle (reusable): </h1>
<p id="presentTime"></p>

<script type="text/babel">
class Clock extends React.Component {
  constructor(props) {
    super(props);
    this.state = {date: new Date()};
  }

  //life cycle
  componentDidMount() {
    this.timerID = setInterval(
      () => this.tick(),
      1000
    );
  }

  componentWillUnmount() {
    clearInterval(this.timerID);
  }

  //local state
  tick() {
    this.setState({
      date: new Date()
    });
  }

  render() {
    return (
      <div>
        <h2>The current time is {this.state.date.toLocaleTimeString()}.</h2>
      </div>
    );
  }
}

function App1() {
  return (
    <div>
      <Clock />
      <Clock />
      <Clock />
	  <Clock />
    </div>
  );
}

ReactDOM.render(<App1 />, document.getElementById('presentTime'));

</script>

</body>
</html>