/*

Author: Paul Burgwardt
Created 9/17/12
Modified 9/17/12

Uses Lab03 and instead incorporates a function to verify correctness
Learn how to instantiate functions and not use cin/cout within them, aside from main

New Stuff-
set tabstop=4; Number of characters to indent
set expandtab;
set autoindent; Automatically indent
syntax on; 

*/

#include <iostream>
using namespace std;
#include <string>

/*
Validates operator and expression, returning the following values with associated meaning-
0 = No errors, expression is valid and equal
1 = Operator is valid, but expression doesn't equal
2 = Operator is invalid
*/
int inputCheck(string alter1, int num1, int num2, int num3) {

if (alter1 == "+") {
  	if (num1 + num2 == num3) {
		return 0; // Operator valid, expression equals
	}
	else {
		return 1; // Operator valid, expression doesn't equal
	}
  }
  else if (alter1 == "-") {
	if (num1 - num2 == num3) {
		return 0;
	}
	else {
		return 1; // Operator valid, expression doesn't equal
	}
  }
  else if (alter1 == "*") {
	if (num1 * num2 == num3) {
		return 0;
	}
	else {
		return 1; // Operator valid, expression doesn't equal
	}
  }
  else if (alter1 == "/") {
	if (num1 / num2 == num3) {
		return 0;
	}
	else {
		return 1; // Operator valid, expression doesn't equal
	}
  }
  else if (alter1 == "%") {
	if (num1 % num2 == num3) {
		return 0;
	}
	else {
		return 1; // Operator valid, expression doesn't equal
	}
  }
  else {
	return 2; // Operator is invalid to begin with
  }

}

/*
The main function that takes in the operator/numbers and creates the expression
*/

int main() {
  string alter1; // Had problems labeling as operator
  alter1 = "";
  int num1, num2, num3, anyErrors; // Creates int variables
  cout << "Enter an arithmetic expression: \n";
  cin >> alter1 >> num1 >> num2 >> num3; // Ask user for input to place in variables
  
  anyErrors = inputCheck(alter1, num1, num2, num3); // Sends the operator and numbers to the inputCheck function and sets result to anyErrors variable
  
  if (anyErrors == 0) {
	cout << num1 << " " << alter1 << " " << num2 << " == "	<< num3 << "\n\n"; // Expression is valid
  }
  else if (anyErrors == 1) {
	cout << num1 << " " << alter1 << " " << num2 << " != "	<< num3 << "\n\n"; // Expression is invalid
  }
  else if (anyErrors == 2) {
	cout << "You are an idiot.  This operator clearly does not exist.\n" << "Try again, and do better.\n\n"; // Operator is invalid
  }

  return 0;
}

