<!DOCTYPE html>
<html lang="en">

<title>Demostration of Handling Shared Events in React</title>
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src= "https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<body>

<h1> Demostration of Handling Shared Events in React</h1>
<div id="root"></div>

<script type="text/babel">

const currencyNames = {
  p: 'BritishPound',
  e: 'Euro'
};

function toGBP(euro) {//Euro
  return euro / 1.11;
}

function toEuro(gbp) {//GBP
  return gbp * 1.11;
}

function tryConvert(money, convert) {
  const input = parseFloat(money);
  if (Number.isNaN(input)) {
    return '';
  }
  const output = convert(input);
  const rounded = Math.round(output * 1000) / 1000;
  return rounded.toString();
}

function CarDecision(props) {
  if (props.gbp >= 5000) {
    return <h2>I can buy a car.</h2>;
  }
  return <h2>I cannot buy a car!.</h2>;
}

class SavingsInput extends React.Component {
  constructor(props) {
    super(props);
    this.handleChange = this.handleChange.bind(this);
  }

  handleChange(e) {
    this.props.onSavingsChange(e.target.value);
  }

  render() {
    const money = this.props.money;
    const exRate = this.props.exRate;
    return (
      <fieldset>
        <legend>Enter savings in {currencyNames[exRate]}:</legend>
        <input value={money}
               onChange={this.handleChange} />
      </fieldset>
    );
  }
}

class ExchangeConverter extends React.Component {
  constructor(props) {
    super(props);
    this.handleGBPChange = this.handleGBPChange.bind(this);
    this.handleEuroChange = this.handleEuroChange.bind(this);
    this.state = {money: '', exRate: 'p'};
  }

  handleGBPChange(money) {
    this.setState({exRate: 'p', money});
  }

  handleEuroChange(money) {
    this.setState({exRate: 'e', money});
  }

  render() {
    const exRate = this.state.exRate;
    const money = this.state.money;
    const gbp = exRate === 'e' ? tryConvert(money, toGBP) : money;
    const euro = exRate === 'p' ? tryConvert(money, toEuro) : money;

    return (
      <div>
        <SavingsInput
          exRate="p"
          money={gbp}
          onSavingsChange={this.handleGBPChange} />
        <SavingsInput
          exRate="e"
          money={euro}
          onSavingsChange={this.handleEuroChange} />
        <CarDecision
          gbp={parseFloat(gbp)} />
      </div>
    );
  }
}

ReactDOM.render(
  <ExchangeConverter />,
  document.getElementById('root')
);



</script>

</body>
</html>