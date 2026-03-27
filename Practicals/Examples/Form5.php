<!DOCTYPE html>
<html lang="en">

<title>Demostration of Forms in React</title>
<script src= "https://unpkg.com/react@16/umd/react.production.min.js"></script>
<script src= "https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>
<script src= "https://unpkg.com/babel-standalone@6.15.0/babel.min.js"></script>
<body>

<h1> Demostration of Forms in React</h1>
<div id="root"></div>

<script type="text/babel">

class NameForm extends React.Component {
  constructor(props) {
    super(props);
    this.state = {value: ''};
	//this.state = {value: 'Write your Name'};

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleChange(event) {
	  this.setState({value: event.target.value});
	  //this.setState({value: event.target.value.toLowerCase()});
	  //perform validation length of the input values or others
	  //const textval = this.state.value;
		var textval = this.state.value;
		//if ((textval.length < 5) || (textval.length > 15))
			//alert("Your Character must be 5 to 15 Character");
		//user validation of the special characters
		var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";		
		for (var i = 0; i < textval.length; i++) {
			if (iChars.indexOf(textval.charAt(i)) != -1) {
				alert ("Your username should not have !@#$%^&*()+=-[]\\\';,./{}|\":<>? \nThese are not allowed.\n Please remove them and try again.");
				//return false;
			}
		}		
		
		//if(isNaN(textval))
			//alert(textval);
  }

//without .preventDefault() the submitted form would be refreshed
  handleSubmit(event) {
    alert('The submitted name is: ' + this.state.value);
    event.preventDefault();
  }

  render() {
    return (
      <form onSubmit={this.handleSubmit}>
        <label>
          Name:
          <input type="text" value={this.state.value} onChange={this.handleChange} />
        </label>
        <input type="submit" value="Submit" />
      </form>	  
    );
  }
}

ReactDOM.render(
  <NameForm />,
  document.getElementById('root')
);


</script>

</body>
</html>