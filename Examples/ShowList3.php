<!DOCTYPE html>
<html lang="en">

<title>Unique Keys in List of Items in React</title>
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src= "https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<body>

<h1> Demostration of Unique Keys in List of Items in React</h1>
<div id="root"></div>

<script type="text/babel">

function BlogMsg(props) {
  const sidebar = (
    <ul>
      {props.posts.map((post) =>
        <li key={post.id}>
          {post.title}
        </li>
      )}
    </ul>
  );
  const content = props.posts.map((post) =>
    <div key={post.id}>
      <h3>{post.title}</h3>
      <p>{post.content}</p>
    </div>
  );
  return (
    <div>
      {sidebar}
      <hr />
      {content}
    </div>
  );
}

const posts = [
  {id: 1, title: 'Welcome to Keele University', content: 'Learning React in CSC-30025!'},
  {id: 2, title: 'Welcome to Computing!', content: 'Learning React is fun!'}
];
ReactDOM.render(
  <BlogMsg posts={posts} />,
  document.getElementById('root')
);


</script>

</body>
</html>