/*
Author:  Paul Burgwardt
Created On:  9/3/12
Last Modified:  9/1/12
Purpose:  TBD
*/
#include <iostream>
using namespace std;

int main() {

    int P, X, Q, R, Y, Sum, Product, Difference, Division; //Creates the integer variables
    cout << "\nEnter Five Integers: \n";
    cin >> X >> Y >> P >> Q >> R; // Asks user for input to fill variables

    cout << "Out Of Order: " << P << " " << X << " " << Q << " " << R << " " << Y << endl; //Displays Integers out of order
    Sum = (X + Y); //Performs summation and sets as Sum
    cout << "Sum:  A = " << Sum << endl;
    Product = (Sum * P); //Performs multiplication of A and P, declares as B
    cout << "Product:  B = " << Product << endl;
    Difference = (Product - Q); //Difference of Q from B and sets as C
    cout << "Difference:  C = " << Difference << endl;
    Division = (Difference / R); //Division of C by R and sets result as D
    cout << "Division:  D = " << Division << "\n\n";

    return 0;
}
