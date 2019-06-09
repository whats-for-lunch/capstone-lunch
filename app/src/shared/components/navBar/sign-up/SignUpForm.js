import React, {useState} from 'react';
import {httpConfig} from "../../../misc/http-config";
import * as Yup from "yup";
import {Formik} from "formik";

import {SignUpFormContent} from "./SignUpFormContent";

export const SignUpForm = () => {
	const signUp = {
		profileEmail: "",
		profileFirstName: "",
		profileLastName: "",
		profilePassword: "",
		profilePasswordConfirm: ""
	};

	const [status, setStatus] = useState(null);
	const validator = Yup.object().shape({
		profileEmail: Yup.string()
			.email("email must be a valid email")
			.required('email is required'),
		profileFirstName: Yup.string()
			.required("profile First Name is required"),
		profileLastName: Yup.string()
			.required("profile Last Name is required"),
		profilePassword: Yup.string()
			.required("Password is required")
			.min(8, "Password must be at least eight characters"),
		profilePasswordConfirm: Yup.string()
			.required("Password Confirm is required")
			.min(8, "Password must be at least eight characters"),
	});

	const submitSignUp = (values, {resetForm}) => {
		console.log('opps');
		httpConfig.post("/apis/sign-up/", values)
			.then(reply => {
					let {message, type} = reply;
					setStatus({message, type});
					if(reply.status === 200) {
						resetForm();
					}
				}
			);
	};

	return (
		<Formik
			initialValues={signUp}
			onSubmit={submitSignUp}
			validationSchema={validator}
		>
			{SignUpFormContent}
		</Formik>
	)
};