<!DOCTYPE html>
<html lang="en">

<title>Learning the Properties of React Components</title>
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src= "https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<body>

<div id="root"></div>

<script type="text/babel">
function formatDate(date) {
  return date.toLocaleDateString();
}

//Following the React Component
function Flower(props) {
  return (
    <div className="Flower">
      <div className="UserInfo">
        <img
          className="Flowers"
          src={props.author.flowerUrl}
          alt={props.author.name}
        />
        <div className="UserInfo-name">
          {props.author.name}
        </div>
      </div>
      <div className="Flower-text">{props.text}</div>
      <div className="Flower-date">
        {formatDate(props.date)}
      </div>
    </div>
  );
}

const Fdetails = {  
  text: 'Learning the Properties of React...Hope you have enjoyed!',
  date: new Date(),
  author: {
    name: 'Beautiful Butterfly...',
	flowerUrl: 'https://images.pexels.com/photos/462118/pexels-photo-462118.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=200&w=160',
  },
};
ReactDOM.render(
  <Flower
    date={Fdetails.date}
    text={Fdetails.text}
    author={Fdetails.author}
  />,
  document.getElementById('root')
);
</script>

</body>
</html>