/*

	Author: Paul Burgwardt
	Created 9/24/12
	Modified 9/24/12

	Uses Lab02 and instead uses functions so no computation is done within the main function

*/

#include <iostream>
using namespace std;
#include <cmath>

void compute(int& X, int& Y, int& P, int& Q, int& R, int& A, int& B, int& C, int& D) {
	A = (X + Y); //Performs summation of X and Y, and sets as A
	
	B = (A * P); //Performs multiplication of A and P, declares as B
	
	C = (B - Q); //Difference of Q from B and sets as C
	
	D = (C / R); //Division of C by R and sets result as D
}

/*
The main function that takes in the numbers and performs calculations using multiple functions
*/

int main() {
	int X, Y, P, Q, R, A, B, C, D; //Creates the integer variables
    cout << "\nEnter Five Integers: \n";
    cin >> X >> Y >> P >> Q >> R; // Asks user for input to fill variables

	if (X > 0 && Y > 0 && P > 0 && Q > 0 && R > 0) {
	
		/*
			At this point, all numbers are valid.
			
			Numbers are sent to the computer function to determine values
			
		*/
		
		compute(X, Y, P, Q, R, A, B, C, D);
		
		cout << "Out of Order: " << P << " " << X << " " << Q << " " << R << " " << Y << "\n";
		cout << "Sum: A = " << A << "\nProduct: B = " << B << "\nDifference: C = " << C << "\nDivision: D = " << D << "\n\n"; 
		
	} else {
		cout << "At least one of your inputs is incorrect.  Try again.\n\n";
	}

    return 0;
}

