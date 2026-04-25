/*
/ fix error, check all naming follow naming guidelines, add invis uninvis button to password /peak feautre
/ make states only update when unselecting boxes
/confirm email should only update after typeing its it box same with confirm password
/add sanity elements htmlentites
/change to onBlur only send when loseing focus
*/

class RegistrationForm extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            userName: "",
            phone: "",
            email: "",
            confirmEmail: "",
            password: "",
            confirmPassword: "",

            userNameError: "",
            phoneErorr: "",
            emailErorr: "",
            confirmEmailError: "",
            passwordErorr: "",
            confirmPasswordError: "",

            emailAvailability: "",
            formMessage: "",

            serverErrors: window.registerErrors || [],
            serverSuccess: window.registerSuccess || "",

            touched: {
                userName: false,
                phone: false,
                email: false,
                confirmEmail: false,
                password: false,
                confirmPassword: false
            }
        };

        this.handleChange = this.handleChange.bind(this);
        this.handleBlur = this.handleBlur.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.checkEmailAvailability = this.checkEmailAvailability.bind(this);
        this.runValidation = this.runValidation.bind(this);
        this.getInputClass = this.getInputClass.bind(this);
        this.getButtonClass = this.getButtonClass.bind(this);
    }

    validateUserName(v) {
        if (v.trim() === "") return "Username empty";
        if (!/^[A-Za-z0-9_ ]{3,30}$/.test(v)) return "Invalid username";
        return "";
    }

    validatePhone(v) {
        if (v.trim() === "") return "Phone empty";
        if (!/^[0-9]+$/.test(v)) return "Numbers only";
        if (v.length !== 10) return "Must be 10 digits";
        return "";
    }

    validateEmail(v) {
        if (v.trim() === "") return "Email required";
        if (!/^[\w.-]+@([\w-]+\.)+[\w-]{2,}$/.test(v)) return "Invalid email";
        return "";
    }

    confirmEmail(v) {
        if (v.trim() === "") return "Confirm email";
        if (v !== this.state.email) return "Emails must match";
        return "";
    }

    validatePassword(v) {
        if (v.trim() === "") return "Password required";
        if (!/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(v)) {
            return "Weak password";
        }
        return "";
    }

    confirmPassword(v) {
        if (v.trim() === "") return "Confirm password";
        if (v !== this.state.password) return "Passwords must match";
        return "";
    }

    checkEmailAvailability(email) {
        if (this.validateEmail(email) !== "") {
            this.setState({ emailAvailability: "" });
            return;
        }

        this.setState({ emailAvailability: "Checking..." });

        fetch("index.php?action=checkEmailExistController&email=" + encodeURIComponent(email))
            .then((res) => {
                if (!res.ok) throw new Error("Network error");
                return res.json();
            })
            .then((data) => {
                this.setState({
                    emailAvailability: data.exists ? "Email already in use" : "Email available"
                });
            })
            .catch(() => {
                this.setState({ emailAvailability: "Error checking email" });
            });
    }

    handleChange(e) {
        const { name, value } = e.target;
        this.setState({
            [name]: value,
            formMessage: "",
            serverErrors: [],
            serverSuccess: ""
        });
    }

    handleBlur(e) {
        const name = e.target.name;

        this.setState(
            (prev) => ({
                touched: {
                    ...prev.touched,
                    [name]: true
                }
            }),
            () => this.runValidation(name)
        );
    }

    runValidation(name) {
        const v = this.state[name];

        if (name === "userName") {
            this.setState({ userNameError: this.validateUserName(v) });
        }

        if (name === "phone") {
            this.setState({ phoneErorr: this.validatePhone(v) });
        }

        if (name === "email") {
            const err = this.validateEmail(v);
            this.setState(
                {
                    emailErorr: err,
                    emailAvailability: "",
                    confirmEmailError: this.state.touched.confirmEmail ? this.confirmEmail(this.state.confirmEmail) : ""
                },
                () => {
                    if (err === "") this.checkEmailAvailability(v);
                }
            );
        }

        if (name === "confirmEmail") {
            this.setState({ confirmEmailError: this.confirmEmail(v) });
        }

        if (name === "password") {
            this.setState({
                passwordErorr: this.validatePassword(v),
                confirmPasswordError: this.state.touched.confirmPassword ? this.confirmPassword(this.state.confirmPassword) : ""
            });
        }

        if (name === "confirmPassword") {
            this.setState({ confirmPasswordError: this.confirmPassword(v) });
        }
    }

    handleSubmit(e) {
        const errors = {
            userNameError: this.validateUserName(this.state.userName),
            phoneErorr: this.validatePhone(this.state.phone),
            emailErorr: this.validateEmail(this.state.email),
            confirmEmailError: this.confirmEmail(this.state.confirmEmail),
            passwordErorr: this.validatePassword(this.state.password),
            confirmPasswordError: this.confirmPassword(this.state.confirmPassword)
        };

        this.setState({
            ...errors,
            touched: {
                userName: true,
                phone: true,
                email: true,
                confirmEmail: true,
                password: true,
                confirmPassword: true
            }
        });

        const hasErrors =
            Object.values(errors).some((err) => err !== "") ||
            this.state.emailAvailability === "Email already in use" ||
            this.state.emailAvailability === "Error checking email";

        if (hasErrors) {
            e.preventDefault();
            this.setState({ formMessage: "Fix errors before submitting" });
        }
    }

    getInputClass(name, error) {
        if (!this.state.touched[name]) return "input-field";
        if (error !== "") return "input-field input-error";

        if (name === "email") {
            if (this.state.emailAvailability === "Email already in use") {
                return "input-field input-error";
            }
            if (this.state.emailAvailability === "Email available") {
                return "input-field input-valid";
            }
            return "input-field";
        }

        return "input-field input-valid";
    }

    getButtonClass() {
        const errors = [
            this.state.userNameError,
            this.state.phoneErorr,
            this.state.emailErorr,
            this.state.confirmEmailError,
            this.state.passwordErorr,
            this.state.confirmPasswordError
        ];

        const hasErrors =
            errors.some((err) => err !== "") ||
            this.state.emailAvailability === "Email already in use" ||
            this.state.emailAvailability === "Error checking email";

        const allTouched = Object.values(this.state.touched).every((v) => v);

        return allTouched && !hasErrors
            ? "Form-Button button-success"
            : "Form-Button button-error";
    }

    render() {
        const emailMessageClass =
            this.state.emailAvailability === "Email available"
                ? "Success-Message"
                : "Error-Message";

        return (
            <div className="container">
                <div className="registeration-container">
                    <h1 className="header">Registeration Form</h1>

                    {this.state.serverSuccess && (
                        <div className="Success-Message">{this.state.serverSuccess}</div>
                    )}

                    {this.state.serverErrors.length > 0 && (
                        <div className="Error-Message">
                            {this.state.serverErrors.map((error, index) => (
                                <div key={index}>{error}</div>
                            ))}
                        </div>
                    )}

                    <form
                        method="POST"
                        action="index.php?action=registerSubmit"
                        onSubmit={this.handleSubmit}
                        autoComplete="off"
                    >
                        <input type="text" name="fakeuser" autoComplete="username" style={{ display: "none" }} tabIndex="-1" />
                        <input type="password" name="fakepass" autoComplete="current-password" style={{ display: "none" }} tabIndex="-1" />

                        <div className="form-group">
                            <input className={this.getInputClass("userName", this.state.userNameError)} type="text" name="userName" value={this.state.userName} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="off" required />
                            <label className="floating-label">Username</label>
                        </div>
                        {this.state.touched.userName && this.state.userNameError && <div className="Error-Message">{this.state.userNameError}</div>}

                        <div className="form-group">
                            <input className={this.getInputClass("phone", this.state.phoneErorr)} type="text" name="phone" value={this.state.phone} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="off" required />
                            <label className="floating-label">Phone</label>
                        </div>
                        {this.state.touched.phone && this.state.phoneErorr && <div className="Error-Message">{this.state.phoneErorr}</div>}

                        <div className="form-group">
                            <input className={this.getInputClass("email", this.state.emailErorr)} type="text" name="email" value={this.state.email} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="off" required />
                            <label className="floating-label">Email</label>
                        </div>
                        {this.state.touched.email && this.state.emailErorr && <div className="Error-Message">{this.state.emailErorr}</div>}
                        {this.state.touched.email && this.state.emailErorr === "" && this.state.emailAvailability && (
                            <div className={emailMessageClass}>{this.state.emailAvailability}</div>
                        )}

                        <div className="form-group">
                            <input className={this.getInputClass("confirmEmail", this.state.confirmEmailError)} type="text" name="confirmEmail" value={this.state.confirmEmail} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="off" required />
                            <label className="floating-label">Confirm Email</label>
                        </div>
                        {this.state.touched.confirmEmail && this.state.confirmEmailError && <div className="Error-Message">{this.state.confirmEmailError}</div>}

                        <div className="form-group">
                            <input className={this.getInputClass("password", this.state.passwordErorr)} type="password" name="password" value={this.state.password} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="new-password" required />
                            <label className="floating-label">Password</label>
                        </div>
                        {this.state.touched.password && this.state.passwordErorr && <div className="Error-Message">{this.state.passwordErorr}</div>}

                        <div className="form-group">
                            <input className={this.getInputClass("confirmPassword", this.state.confirmPasswordError)} type="password" name="confirmPassword" value={this.state.confirmPassword} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="new-password" required />
                            <label className="floating-label">Confirm Password</label>
                        </div>
                        {this.state.touched.confirmPassword && this.state.confirmPasswordError && <div className="Error-Message">{this.state.confirmPasswordError}</div>}

                        <button className={this.getButtonClass()} type="submit">Register</button>
                        {this.state.formMessage && <div className="Error-Message">{this.state.formMessage}</div>}
                    </form>
                </div>
            </div>
        );
    }
}

ReactDOM.render(<RegistrationForm />, document.getElementById("register-root"));