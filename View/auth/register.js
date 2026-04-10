/*
/ fix error, check all naming follow naming guidelines, add invis uninvis button to password /peak feautre
/ make states only update when unselecting boxes
/confirm email should only update after typeing its it box same with confirm password
/add sanity elements htmlentites
/change to onBlur only send when loseing focus
*/


class RegistrationForm extends React.Component{
    constructor(props){
        super(props)


    this.state ={
        userName: "",
        phone:"",
        email: "",
        confirmEmail: "",
        password: "",
        confirmPassword: "",

        userNameError: "",
        phoneErorr:"",
        emailErorr: "",
        confirmEmailError: "",
        passwordErorr: "",
        confirmPasswordError: "",

        userNameAvailability:"",
        formMessage:""


    };
    
    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
    this.checkUserNameAvailability = this.checkUserNameAvailability.bind(this);
    }

    validateUserName(value){
        if(value.trim()=== "") {
            return "Username empty";
        }
        if (!/^[A-Za-z0-9_ ]{3,30}$/.test(value)){
            return "Username Must contain Letters only";
        }
        return "";
    }

    //to do validate first number is 07
    validatePhone(value){
        if(value.trim()=== "") {
            return "phone empty";
        }
        if (!/^[0-9]+$/.test(value)){
            return "Phone Number Must contain numbers only";
        }
        if (value.length !==10){
            return "Phone number must be exactly 10 digits";
        }
        return "";
    }

    validateEmail(value){
        if(value.trim()=== "") {
            return "Email is Requred";
        }
        if (!/^[\w.-]+@([\w-]+\.)+[\w-]{2,4}$/.test(value)){
            return "Must be valid email";
        }
        return "";
    }
    //add confimration statement
    confirmEmail(value){
        if(value.trim()=== "") {
            return "Must Confirm Email";
        }
        if (value !== this.state.email){
            return "Must match email";
        }
        return "";
    }
    // https://ihateregex.io/expr/password/
    //Minimum eight characters, at least one upper case English letter, one lower case English letter, one number and one special character
    validatePassword(value){
        if(value.trim()=== "") {
            return "Password is Required";
        }
        if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/.test(value)){
            return "Must contain a minimum of eight characters, at least one upper case English letter, one lower case English letter, one number and one special character";
        }
        return "";
    }
    //todo add confirmation condition
    confirmPassword(value){
        if(value.trim()=== "") {
            return "Must confirm Password";
        }
        if (value !== this.state.password){
            return "Passwords Must match";
        }
        return "";
    }

    handleChange(event){
        const name = event.target.name;
        const value = event.target.value;

        this.setState({[name]: value}, () => {
        if( name === "userName"){
            this.setState({
               userNameError: this.validateUserName(value),
               userNameAvailability: ""
            });
        }
        if( name === "phone"){
            this.setState({
               phoneErorr: this.validatePhone(value)
            });
        }
        if( name === "email"){
            this.setState({
               emailErorr: this.validateEmail(value),
               confirmEmailError: this.confirmEmail(this.state.confirmEmail)
        
            });
        }
        if( name === "confirmEmail"){
            this.setState({
               confirmEmailError: this.confirmEmail(value)
            });
        }
        if( name === "password"){
            this.setState({
               passwordErorr: this.validatePassword(value),
               confirmPasswordError: this.confirmPassword(this.state.confirmPassword)
            });
        }
        if( name === "confirmPassword"){
            this.setState({
               confirmPasswordError: this.confirmPassword(value),
        
            });
        }
    });
    }

    checkUserNameAvailability(){
        const userNameError = this.validateUserName(this.state.userName)

        this.setState({ userNameError: userNameError})

        if(userNameError !==""){
            return;
        }

        fetch("index.php?action=checkUserName&userName=" + encodeURIComponent(this.state.userName))
        .then(response => response.json())
        .then(data =>{
            if (data.exists){
                this.setState({userNameAvailability: "Username is already in use"})

            } else { this.setState({userNameAvailability: "Username is available"})}
        })
        .catch(error => {
            this.setState({userNameAvailability: "could not check username right now"})
        });
    }

    handleSubmit(event){
        const userNameError = this.validateUserName(this.state.userName);
        const phoneErorr = this.validatePhone(this.state.phone);
        const emailErorr= this.validateEmail(this.state.email);
        const confirmEmailError = this.confirmEmail(this.state.confirmEmail);
        const passwordErorr= this.validatePassword(this.state.password);
        const confirmPasswordError = this.confirmPassword(this.state.confirmPassword);
        
        this.setState({
           userNameError: userNameError,
           phoneErorr:  phoneErorr,
           emailErorr: emailErorr,
           confirmEmailError: confirmEmailError,
           passwordErorr: passwordErorr,
           confirmPasswordError: confirmPasswordError

        })


        if(
            userNameError !=="" ||
            phoneErorr !=="" ||
            emailErorr !=="" ||
            confirmEmailError !=="" ||
            passwordErorr !=="" ||
            confirmPasswordError !=="" ||
            this.state.userNameAvailability === "Username is already in use"
        ){
            event.preventDefault();
            this.setState({formMessage: "please fix the errors before registering"})
        }
    }


    render(){
        return(
            <div className = "container">
            <div className ="registeration-container">
                <h1 className = "header">Registeration Form</h1>
            <form method="POST" action="index.php?action=registerSubmit" onSubmit={this.handleSubmit}>
                <div className ="form-group">
                <input className="input-field"
                    type = "text"
                    name = "userName"
                    value ={this.state.userName}
                    onChange ={this.handleChange}
                    placeholder = "" required
                   
                /><label className="floating-label">Username</label>
                </div>
                <div style={{color:"red"}}>{this.state.userNameError}</div>

                <div className ="form-group">
                <input className="input-field"
                    type = "text"
                    name = "phone"
                    value ={this.state.phone}
                    onChange ={this.handleChange}
                    placeholder = "" required
                /><label className="floating-label">Phone</label>
                </div>
                <div style={{color:"red"}}>{this.state.phoneErorr}</div>
                
                <div className ="form-group">
                <input className="input-field"
                    type = "text"
                    name = "email"
                    value ={this.state.email}
                    onChange ={this.handleChange}
                    placeholder = "" required
                /><label className="floating-label">email</label>
                <div style={{color:"red"}}>{this.state.emailErorr}</div>
                </div>
                
                <div className ="form-group">
                <input className="input-field"
                    type = "text"
                    name = "confirmEmail"
                    value ={this.state.confirmEmail}
                    onChange ={this.handleChange}
                    placeholder = "" required
                /><label className="floating-label">confirm Email</label>
                <div style={{color:"red"}}>{this.state.confirmEmailError}</div>
                </div>

                <div className ="form-group">
                
                <input className="input-field"
                    type = "password"
                    name = "password"
                    value ={this.state.password}
                    onChange ={this.handleChange}
                    placeholder = "" required
                /><label className="floating-label">password</label>
                <div style={{color:"red"}}>{this.state.passwordErorr}</div>
                </div>

                <div className ="form-group">
                <input className="input-field"
                    type = "password"
                    name = "confirmPassword"
                    value ={this.state.confirmPassword}
                    onChange ={this.handleChange}
                    placeholder = "" required
                /><label className="floating-label">Confrim Password</label>
                <div style={{color:"red"}}>{this.state.confirmPasswordError}</div>
                </div>

                <button className = "Form-Button" type="submit">Register</button>
                <div style={{color:"red"}}>{this.state.formMessage}</div>
            </form>
            </div>
            </div>
        );
    }
   
}


ReactDOM.render(
        <RegistrationForm />, document.getElementById("register-root")
        )
