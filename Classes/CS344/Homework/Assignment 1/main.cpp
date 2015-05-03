#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <fstream>
#include <assert.h>
#include <time.h>

#include "sorts.h"

using namespace std;

// swap with no temp
#define swap(a,b)	((a)^=(b), (b)^=(a), (a)^=(b))

// median finder
void select(int array[], int size, int K, int &answer);

// helpers
void show(int array[], int size);
void copy(int src[], int dest[], int size);
void shuffle(int array[], int size);
void is_sorted(int array[], int size);

// pivot choosers
int random_pivot(int [], int);
int fixed_pivot(int [], int);
int median_pivot(int [], int);

void plot(int);

bool running = false;

///////////////////////////////////////////////////////////////////////
// main: testing all sorts
///////////////////////////////////////////////////////////////////////
int main(int argc, char *argv[])
{
	assert(argc > 1);

	srand (time(NULL));
	int cost;

	// debug (show output)
	// plot (write to csv)
	int debug = 1;
	int plotting = 0;

	// get size 
	int size = atoi(argv[1]);
	
	// allocate array
	int test_array[size];
	for (int current_element = 0; current_element < size; current_element++) {
		test_array[current_element] = size - current_element;
	}
	//shuffle(test_array, size);
	if(debug){
		cout << "Created Array: [ ";
		for(int i = 0; i < size; i++)
		{
			cout << test_array[i] << " ";
		}
		cout << "]\n";

		cout << "Size: " << size << "\nSorting...\n";
	}

	int array[size];

	if(plotting){
		running = true;
		cout << "Plotting...";
		plot(128);
	}

	// testing mergesort
	setCost(0);
	copy(test_array, array, size);
	msort(array, 0, size-1);
	is_sorted(array, size);
	cost = getCost();
	if(debug){
		cout << "MergeSort: " << cost <<  " [ ";
		show(array, size);
		cout << "]\n";
	}
	// testing quicksort (with random pivot)
	setCost(0);
	copy(test_array, array, size);
	int randnum = random_pivot(array,size-1);
	my_qsort(array, 0, size, random_pivot);
	is_sorted(array, size);
	cost = getCost();
	if(debug){
		cout << "QuickSort (RP=" << randnum << "): " << cost <<  " [ ";
		show(array, size);
		cout << "]\n";
	}
	// testing quicksort (with median pivot)
	setCost(0);
	copy(test_array, array, size);
	my_qsort(array, 0, size, median_pivot);
	is_sorted(array, size);
	if(debug){
		cout << "QuickSort (MP): " << cost <<  " [ ";
		show(array, size);
		cout << "]\n";
	}
	// testing insertion sort
	setCost(0);
	copy(test_array, array, size);
	isort(array, size);
	is_sorted(array, size);
	cost = getCost();
	if(debug){
		cout << "InsertionSort: " << cost <<  " [ ";
		show(array, size);
		cout << "]\n";
	}
	// testing selection sort
	setCost(0);
	copy(test_array, array, size);
	ssort(array, size);
	is_sorted(array, size);
	cost = getCost();
	if(debug){
		cout << "SelectionSort: " << cost <<  " [ ";
		show(array, size);
		cout << "]\n";
	}
	// testing bubble sort
	setCost(0);
	copy(test_array, array, size);
	bsort(array, size);
	is_sorted(array, size);
	cost = getCost();
	if(debug){
		cout << "BubbleSort: " << cost <<  " [ ";
		show(array, size);
		cout << "]\n";
	}
	return 0;
}

///////////////////////////////////////////////////////////////////////
// HELPERS
///////////////////////////////////////////////////////////////////////

// randomly shuffle array
void shuffle(int array[], int size)
{
	int index;
	srand(time(0));
	for (int i=size-1; i>0; i--) {
		index = (rand() % i) + 1;
		swap(array[i], array[index]);
	}
}

// display array
void show(int array[], int size)
{
	for (int i=0; i<size; i++) {
		cerr << array[i] << " ";
	}
}

// array is sorted
void is_sorted(int array[], int size)
{
	for (int i=0; i<size-1; i++) {
		assert(array[i] <= array[i+1]);
	}
}

// copy array
void copy(int src[], int dest[], int size)
{
	for (int i=0; i<size; i++) {
		dest[i] = src[i];
	}
}

// pivot choosers
int fixed_pivot(int array[], int size)
{
	return array[0];
}

int random_pivot(int array[], int size)
{
	return array[rand()%size];
}

int median_pivot(int array[], int size)
{
	int pivot;
	select(array, size, size>>1, pivot);
	return pivot;
}

void select(int array[], int size, int K, int &answer)
{
	if((size % 2) == 0)
	{
		answer = (array[K] + array[K+1])/2;
	}
	else
	{
		answer = array[K];
	}
}

void plot(int n){
	ofstream results;
	results.open("results.csv");
	int cost;
	results << "N,Merge Sort,Quick Sort (RANDOM),Quick Sort (MEDIAN),Insertion Sort,Selection Sort,Bubble Sort,\n";
	for(int i = 1; i < n; i++){
		int test_array[i];
		int array[i];
		for (int current_element = 0; current_element < i; current_element++) {
			test_array[current_element] = i - current_element;
		}
		//shuffle(test_array, i);
		results << i << ",";
		// Merge Sort
		setCost(0);
		copy(test_array, array, i);
		msort(array, 0, i-1);
		is_sorted(array, i);
		cost = getCost();
		results << cost << ",";
		// Quick Sort (Random)
		setCost(0);
		copy(test_array, array, i);
		my_qsort(array, 0, i, random_pivot);
		is_sorted(array, i);
		cost = getCost();
		results << cost << ",";
		// Quick Sort (Median)
		setCost(0);
		copy(test_array, array, i);
		my_qsort(array, 0, i, median_pivot);
		is_sorted(array, i);
		results << cost << ",";
		// Insertion Sort
		setCost(0);
		copy(test_array, array, i);
		isort(array, i);
		is_sorted(array, i);
		cost = getCost();
		results << cost << ",";
		// Selection Sort
		setCost(0);
		copy(test_array, array, i);
		ssort(array, i);
		is_sorted(array, i);
		cost = getCost();
		results << cost << ",";
		// Bubble Sort
		setCost(0);
		copy(test_array, array, i);
		bsort(array, i);
		is_sorted(array, i);
		cost = getCost();
		results << cost << ",\n";
		cout << ".";
	}
	results.close();
	running = false;
}