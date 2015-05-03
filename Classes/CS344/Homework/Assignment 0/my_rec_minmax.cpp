//////////////////////////////////////////////////////////////////////////
// PAUL BURGWARDT
// NAME: my_rec_minmax.cpp
//////////////////////////////////////////////////////////////////////////

#include <iostream>
#include <fstream>
#include "assert.h"
#include <string.h>
#include <stdlib.h>

using namespace std;

void rec_minmax( int [], int, int &, int &); // Recursive minmax
void plot( int range ); // Computes cost for arrays of size 1 to range

int cost = 0; // Cost to be incremented by functions

int main( int argc, char *argv[] )
{
	// Debug
	int debugFlag = 0;
	// Create CSV of N and Cost values for range of values
	if(debugFlag)
	{
		plot( 1000 );
	}
	// Check for correct arguments
	if( argc != 2 )
	{
		cout << "Usage: \n\t" << argv[0] << " <filename>" << endl;
	}
	else
	{
		// Check ability to open file
		ifstream input_file( argv[1] );
		if( !input_file.is_open() )
		{
			cout << "Unable to open file." << endl;
		}
		else
		{
			// Read input data
			int numElements;
			input_file >> numElements;
			int array[numElements];
			int i;

			for(i = 0; i < numElements; i++)
			{
				input_file >> array[i];
			}

			// Verify input data
			if(debugFlag)
			{
				cout << "Number of elements: " << numElements << endl;
				cout << "Array: ";

				for(i = 0; i < numElements; i++)
				{
					cout << array[i] << " ";
				}
				cout << endl;
			}
			

			// Sort input data
			int min = 0, max = 0;
			rec_minmax(array, numElements, min, max);

			// Report findings
			if(debugFlag)
			{
				cout << "\n\n";
				for(i = 0; i < numElements; i++)
				{
					cout << array[i] << " ";
				}
			}
			/*
			cout << "\nSmallest #: " << min << endl;
			cout << "Largest #: " << max << endl;
			cout << "Cost: " << cost << endl;
			*/

			printf("%d %d %d %d\n", numElements, min, max, cost);

			input_file.close();
		}
	}

	return 0;
}

void rec_minmax(int array[], int size, int &min_answer, int &max_answer)
{
	assert(size > 0);
	if(1 == size)
	{
		min_answer = max_answer = array[0];
		return;
	}
	else if(2 == size)
	{
		cost++;
		if(array[0] < array[1])
		{
			min_answer = array[0];
			max_answer = array[1];
		}
		else
		{
			min_answer = array[1];
			max_answer = array[0];
		}
		return;
	}

	// SIZE > 2

	// min, max of left half
	int left_min, left_max;
	left_min = left_max = -1;
	int left_size;
	left_size = size / 2;
	rec_minmax(array, left_size, left_min, left_max);

	// min, max of right half
	int right_min, right_max;
	right_min = right_max = -1;
	int right_size;
	right_size = size - left_size;

	// instead of creating another array, use offset
	rec_minmax(array+left_size, right_size, right_min, right_max);

	// compute
	cost++;
	if(left_min < right_min)
	{
		min_answer = left_min;
	}
	else
	{
		min_answer = right_min;
	}

	cost++;
	if(left_max > right_max)
	{
		max_answer = left_max;
	}
	else
	{
		max_answer = right_max;
	}
}

void plot( int range )
{
	// Set up file to write to
	// Loop range times
		// Initialize size of array
		// Initialize random elements
		// Send recursively
		// Write values to csv

	ofstream data;
	data.open("data.csv");
	int iteration;
	for(iteration = 1; iteration < range; iteration++)
	{
		cost = 0;
		// Initialize size of array
		int currentArray[iteration];
		int e, randomNum;
		// Initialize random elements
		for(e = 0; e < iteration; e++)
		{
			int randomNum = rand() % 100;
			currentArray[e] = randomNum;
		}
		// Send array recursively
		int min = 0, max = 0;
		rec_minmax(currentArray, iteration, min, max);
		// Write values to csv
		data << iteration << "," << cost << "," << min << "," << max << ",\n";
	}
	data.close();
}