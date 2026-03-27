<!DOCTYPE html>
<html lang="en">

<title>Displaying List of Items in React</title>
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src= "https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<body>

<h1> List of Items:</h1>
<div id="root"></div>

<script type="text/babel">
function NumberList(props) {
  const numbers = props.numbers;
  const listItems = numbers.map((number) =>
    <li key={number.toString()}>
      {number}
    </li>
  );
  return (
    <ul>{listItems}</ul>
  );
}

const numbers = [1, 2, 3, 4, 5, 6];
ReactDOM.render(
  <NumberList numbers={numbers} />,
  document.getElementById('root')
);

</script>

</body>
</html>