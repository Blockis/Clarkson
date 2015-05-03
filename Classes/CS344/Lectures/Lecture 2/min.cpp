#include <iostream>
#include <fstream>
#include "assert.h"

using namespace std;

void find_minmax(int [], int, int &, int &);
void rec_minmax( int [], int, int &, int &);

int cost;

// Main
int main()
{
	ifstream input_file;
	input_file.open("data.txt");

	int size;

	input_file >> size;

	int array[ size ];
	for(int i = 0; i < size; i++)
	{
		input_file >> array[ i ];
	}

	/* prove that array is initialized */
	cout << "Input Data: ";
	for(int i = 0; i < size; i++)
	{
		cerr << array[ i ] << " ";
	}
	cout << endl << endl;

	int min = 0, max = 0;
	cost = 0;
	//find_minmax(array, size, min, max);
	rec_minmax(array, size, min, max);
	cerr << "The smallest = " << min << endl << "The largest = " << max << endl;
	cerr << "Cost= " << cost << endl;
	return 0;
}

// Find smallest element in an integer array
void find_minmax(int array[], int size, int &min_answer, int &max_answer)
{
	int cost = 0;

	assert(size > 0);

	if (1 == size) {
		min_answer = max_answer = array[0];
		return;
	}

	int min_index = 0;
	min_answer = array[ 0 ];
	for(int i = 1; i < size; i++)
	{
		cost++;
		if(array[ i ] < min_answer)
		{
			min_answer = array[ i ];
			min_index = i;
		}
	}

	max_answer = array[ 0 ];
	for(int i = 1; i < size; i++)
	{
		/*if(min_index == i)
			continue;*/
		if(i != min_index)
		{
			cost++;
			if(array[ i ] > max_answer)
			{
				max_answer = array[ i ];
			}
		}
	}

	cout << "Cost= " << cost << endl;

}

// Find smallest element in an integer array
// Divide and Conquer, recursion

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
	int left_size = size / 2;
	rec_minmax(array, left_size, left_min, left_max);

	// min, max of right half
	int right_min, right_max;
	int right_size = size - left_size;

	int tmp_array[right_size];
	for(int i = 0; i < right_size; i++)
	{
		tmp_array[i] = array[left_size + 1];
	}

	// instead of creating another array,
	// rec_minmax(array+left_size, right_size, right_min, right_max)
	rec_minmax(tmp_array, right_size, right_min, right_max);

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




