<!DOCTYPE html>
<html lang="en">

<title>Clock Using React</title>
<!-- REACT is JavaScript library created by Facebook used for building Web App -->
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>

<body>
<h1> Present time (using REACT) encapsulated in class form with local state: </h1>
<p id="presentTime"></p>

<script type="text/babel">
class Clock extends React.Component {
  constructor(props) {
    super(props);//super() is used in constructor to call the parent object methods, available in newer version of Javascript (ES2015)
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
	//note the change from prop to state below
  render() {
    return (
      <div>
        <h2>The current time is {this.state.date.toLocaleTimeString()}.</h2>
      </div>
    );
  }
}

ReactDOM.render(
  <Clock />,
  document.getElementById('presentTime')
);

</script>

</body>
</html>