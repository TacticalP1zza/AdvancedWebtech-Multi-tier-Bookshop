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
            phoneError: "",
            emailError: "",
            confirmEmailError: "",
            passwordError: "",
            confirmPasswordError: "",

            emailAvailability: "",
            formMessage: "",
            isSubmitting: false,

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
        this.validateAllFields = this.validateAllFields.bind(this);
        this.runValidation = this.runValidation.bind(this);
        this.getInputClass = this.getInputClass.bind(this);
        this.getButtonClass = this.getButtonClass.bind(this);
        this.isFormValid = this.isFormValid.bind(this);
    }

    validateUserName(value) {
        const v = value.trim();

        if (v === "") return "Username is required.";
        if (v.length < 3) return "Username must be at least 3 characters.";
        if (v.length > 30) return "Username must be less than 30 characters.";
        if (!/^[A-Za-z0-9_ ]+$/.test(v)) {
            return "Username can only contain letters, numbers, spaces, and underscores.";
        }

        return "";
    }

    validatePhone(value) {
        const v = value.trim();

        if (v === "") return "Phone number is required.";
        if (!/^[0-9]+$/.test(v)) return "Phone number must contain numbers only.";
        if (v.length !== 10) return "Phone number must be 10 digits, for example 7123456789.";

        return "";
    }

    validateEmail(value) {
        const v = value.trim();

        if (v === "") return "Email is required.";
        if (!/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(v)) {
            return "Please enter a valid email address.";
        }

        return "";
    }

    validateConfirmEmail(value) {
        const v = value.trim();

        if (v === "") return "Please confirm your email address.";
        if (v !== this.state.email.trim()) return "Email addresses must match.";

        return "";
    }

    validatePassword(value) {
        const v = value;

        if (v.trim() === "") return "Password is required.";
        if (v.length < 8) return "Password must be at least 8 characters.";
        if (!/[A-Z]/.test(v)) return "Password must include at least one uppercase letter.";
        if (!/[a-z]/.test(v)) return "Password must include at least one lowercase letter.";
        if (!/[0-9]/.test(v)) return "Password must include at least one number.";
        if (!/[#?!@$%^&*-]/.test(v)) return "Password must include at least one special character.";

        return "";
    }

    validateConfirmPassword(value) {
        if (value.trim() === "") return "Please confirm your password.";
        if (value !== this.state.password) return "Passwords must match.";

        return "";
    }

    checkEmailAvailability(email) {
        const emailError = this.validateEmail(email);

        if (emailError !== "") {
            this.setState({ emailAvailability: "" });
            return;
        }

        this.setState({ emailAvailability: "Checking email..." });

        fetch("index.php?action=checkEmailExistController&email=" + encodeURIComponent(email.trim()))
            .then((res) => {
                if (!res.ok) throw new Error("Network error");
                return res.json();
            })
            .then((data) => {
                this.setState({
                    emailAvailability: data.exists ? "Email already in use." : "Email available."
                });
            })
            .catch(() => {
                this.setState({ emailAvailability: "Error checking email." });
            });
    }

    handleChange(e) {
        const { name, value } = e.target;

        this.setState(
            {
                [name]: value,
                formMessage: "",
                serverErrors: [],
                serverSuccess: ""
            },
            () => {
                this.setState(
                    (prev) => ({
                        touched: {
                            ...prev.touched,
                            [name]: true
                        }
                    }),
                    () => {
                        this.runValidation(name);
                    }
                );
            }
        );
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
            () => {
                this.runValidation(name);

                if (name === "email") {
                    this.checkEmailAvailability(this.state.email);
                }
            }
        );
    }

    runValidation(name) {
        if (name === "userName") {
            this.setState({
                userNameError: this.validateUserName(this.state.userName)
            });
        }

        if (name === "phone") {
            this.setState({
                phoneError: this.validatePhone(this.state.phone)
            });
        }

        if (name === "email") {
            this.setState({
                emailError: this.validateEmail(this.state.email),
                emailAvailability: "",
                confirmEmailError: this.state.touched.confirmEmail
                    ? this.validateConfirmEmail(this.state.confirmEmail)
                    : ""
            });
        }

        if (name === "confirmEmail") {
            this.setState({
                confirmEmailError: this.validateConfirmEmail(this.state.confirmEmail)
            });
        }

        if (name === "password") {
            this.setState({
                passwordError: this.validatePassword(this.state.password),
                confirmPasswordError: this.state.touched.confirmPassword
                    ? this.validateConfirmPassword(this.state.confirmPassword)
                    : ""
            });
        }

        if (name === "confirmPassword") {
            this.setState({
                confirmPasswordError: this.validateConfirmPassword(this.state.confirmPassword)
            });
        }
    }

    validateAllFields() {
        return {
            userNameError: this.validateUserName(this.state.userName),
            phoneError: this.validatePhone(this.state.phone),
            emailError: this.validateEmail(this.state.email),
            confirmEmailError: this.validateConfirmEmail(this.state.confirmEmail),
            passwordError: this.validatePassword(this.state.password),
            confirmPasswordError: this.validateConfirmPassword(this.state.confirmPassword)
        };
    }

    isFormValid() {
        const errors = this.validateAllFields();

        const hasErrors = Object.values(errors).some((error) => error !== "");

        const emailInvalid =
            this.state.emailAvailability === "Email already in use." ||
            this.state.emailAvailability === "Error checking email." ||
            this.state.emailAvailability === "Checking email...";

        return !hasErrors && !emailInvalid;
    }

    handleSubmit(e) {
        const errors = this.validateAllFields();

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

        const hasErrors = Object.values(errors).some((error) => error !== "");

        const emailInvalid =
            this.state.emailAvailability === "Email already in use." ||
            this.state.emailAvailability === "Error checking email." ||
            this.state.emailAvailability === "Checking email...";

        if (hasErrors || emailInvalid) {
            e.preventDefault();
            this.setState({
                formMessage: "Please fix the highlighted errors before submitting."
            });
            return;
        }

        this.setState({ isSubmitting: true });
    }

    getInputClass(name, error) {
        if (!this.state.touched[name]) return "input-field";

        if (error !== "") return "input-field input-error";

        if (name === "email") {
            if (this.state.emailAvailability === "Email already in use.") {
                return "input-field input-error";
            }

            if (this.state.emailAvailability === "Email available.") {
                return "input-field input-valid";
            }

            return "input-field";
        }

        return "input-field input-valid";
    }

    getButtonClass() {
        return this.isFormValid()
            ? "Form-Button button-success"
            : "Form-Button button-error";
    }

    render() {
        const emailMessageClass =
            this.state.emailAvailability === "Email available."
                ? "Success-Message"
                : "Error-Message";

        return (
            <div className="container">
                <div className="registeration-container">
                    <h1 className="header">Registration Form</h1>

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

                        {this.state.touched.userName && this.state.userNameError && (
                            <div className="Error-Message">{this.state.userNameError}</div>
                        )}

                        <div className="form-group">
                            <input className={this.getInputClass("phone", this.state.phoneError)} type="text" name="phone" value={this.state.phone} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="off" required />
                            <label className="floating-label">Phone</label>
                        </div>

                        {this.state.touched.phone && this.state.phoneError && (
                            <div className="Error-Message">{this.state.phoneError}</div>
                        )}

                        <div className="form-group">
                            <input className={this.getInputClass("email", this.state.emailError)} type="text" name="email" value={this.state.email} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="off" required />
                            <label className="floating-label">Email</label>
                        </div>

                        {this.state.touched.email && this.state.emailError && (
                            <div className="Error-Message">{this.state.emailError}</div>
                        )}

                        {this.state.touched.email && this.state.emailError === "" && this.state.emailAvailability && (
                            <div className={emailMessageClass}>{this.state.emailAvailability}</div>
                        )}

                        <div className="form-group">
                            <input className={this.getInputClass("confirmEmail", this.state.confirmEmailError)} type="text" name="confirmEmail" value={this.state.confirmEmail} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="off" required />
                            <label className="floating-label">Confirm Email</label>
                        </div>

                        {this.state.touched.confirmEmail && this.state.confirmEmailError && (
                            <div className="Error-Message">{this.state.confirmEmailError}</div>
                        )}

                        <div className="form-group">
                            <input className={this.getInputClass("password", this.state.passwordError)} type="password" name="password" value={this.state.password} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="new-password" required />
                            <label className="floating-label">Password</label>
                        </div>

                        {this.state.touched.password && this.state.passwordError && (
                            <div className="Error-Message">{this.state.passwordError}</div>
                        )}

                        <div className="form-group">
                            <input className={this.getInputClass("confirmPassword", this.state.confirmPasswordError)} type="password" name="confirmPassword" value={this.state.confirmPassword} onChange={this.handleChange} onBlur={this.handleBlur} placeholder=" " autoComplete="new-password" required />
                            <label className="floating-label">Confirm Password</label>
                        </div>

                        {this.state.touched.confirmPassword && this.state.confirmPasswordError && (
                            <div className="Error-Message">{this.state.confirmPasswordError}</div>
                        )}

                        <button
                            className={this.getButtonClass()}
                            type="submit"
                            disabled={this.state.isSubmitting}
                        >
                            {this.state.isSubmitting ? "Registering..." : "Register"}
                        </button>

                        {this.state.formMessage && (
                            <div className="Error-Message">{this.state.formMessage}</div>
                        )}
                    </form>
                </div>
            </div>
        );
    }
}

ReactDOM.render(<RegistrationForm />, document.getElementById("register-root"));