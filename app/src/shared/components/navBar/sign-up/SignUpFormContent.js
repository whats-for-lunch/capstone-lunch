import React from "react";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import {FormDebugger} from "../../FormDebugger";

export const SignUpFormContent = (props) => {
	const {
		submitStatus,
		values,
		errors,
		touched,
		dirty,
		isSubmitting,
		handleChange,
		handleBlur,
		handleSubmit,
		handleReset
	} = props;
	return (
		<>
			<form onSubmit={handleSubmit}>
				{/*controlId must match what is passed to the initialValues prop*/}
				<div className="form-group">
					<label htmlFor="profileEmail">Email Address</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<i className="far fa-envelope"></i>
							</div>
						</div>
						<input
							className="form-control"
							id="profileEmail"
							type="email"
							value={values.profileEmail}
							placeholder="Enter email"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.profileEmail && touched.profileEmail && (
							<div className="alert alert-danger">
								{errors.profileEmail}
							</div>
						)

					}
				</div>
				{/*controlId must match what is defined by the initialValues object*/}
				<div className="form-group">
					<label htmlFor="profilePassword">Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<i className="fas fa-unlock-alt"></i>
							</div>
						</div>
						<input
							id="profilePassword"
							className="form-control"
							type="password"
							placeholder="Password"
							value={values.profilePassword}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.profilePassword && touched.profilePassword && (
						<div className="alert alert-danger">{errors.profilePassword}</div>
					)}
				</div>
				<div className="form-group">
					<label htmlFor="profilePasswordConfirm">Confirm Your Password</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<i className="fas fa-unlock-alt"></i>
							</div>
						</div>
						<input

							className="form-control"
							type="password"
							id="profilePasswordConfirm"
							placeholder="Password Confirm"
							value={values.profilePasswordConfirm}
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{errors.profilePasswordConfirm && touched.profilePasswordConfirm && (
						<div className="alert alert-danger">{errors.profilePasswordConfirm}</div>
					)}
				</div>


				<div className="form-group">
					<label htmlFor="profileFirstName">First Name</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<i className="fas fa-user"></i>
							</div>
						</div>
						<input
							className="form-control"
							id="profileFirstName"
							type="text"
							value={values.profileFirstName}
							placeholder="@FirstName"
							onChange={handleChange}
							onBlur={handleBlur}

						/>
					</div>
					{
						errors.profileFirstName && touched.profileFirstName && (
							<div className="alert alert-danger">
								{errors.profileFirstName}
							</div>
						)
					}
				</div>


				<div className="form-group">
					<label htmlFor="profileLastName">Last Name</label>
					<div className="input-group">
						<div className="input-group-prepend">
							<div className="input-group-text">
								<i className="fas fa-user"></i>
							</div>
						</div>
						<input
							className="form-control"
							id="profileLastName"
							type="text"
							value={values.profileLastName}
							placeholder="@LastName"
							onChange={handleChange}
							onBlur={handleBlur}
						/>
					</div>
					{
						errors.profileLastName && touched.profileLastName && (
							<div className="alert alert-danger">
								{errors.profileLastName}
							</div>
						)

					}
				</div>
				<div className="form-group">
					<button className="btn btn-outline-warning mb-2" type="submit">Submit</button>
					<button
						className="btn btn-outline-warning mb-2"
						onClick={handleReset}
						disabled={!dirty || isSubmitting}
					>
						Reset
					</button>
				</div>
			</form>
				{
					submitStatus && (<div className={submitStatus.type}>{submitStatus.message}</div>)
				}
		</>


	)
};
