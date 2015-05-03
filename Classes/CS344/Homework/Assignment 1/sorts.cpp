#include <stdio.h>
#include <stdlib.h>
#include <iostream>
#include <assert.h>
#include <time.h>

#include "sorts.h"

using namespace std;

int cost = 0;

///////////////////////////////////////////////////////////////////////
// sorts
///////////////////////////////////////////////////////////////////////

void bsort(int array[], int size)
{
	bool not_sorted = true;	
	while(not_sorted)
	{
		not_sorted = false;
		for(int i = 0; i < size - 1; i++)
		{
			cost++;
			if(array[i] > array[i+1])
			{
				swap(array[i], array[i+1]);
				not_sorted = true;
			}
		}
	}
}

void isort(int array[], int size)
{
	int i, j;
	for(i = 0; i < size; i++)
	{
		for(j = i; j >= 1; j--)
		{
			cost++;
			if(array[j] < array[j-1])
			{
				swap(array[j],array[j-1]);
			}
			else
			{
				break;
			}
		}
	}
}

void ssort(int array[], int size)
{
	int pos_min, tmp;
	for(int i = 0; i < size - 1; i++)
	{
		pos_min = i;
		for(int j = i+1; j < size; j++)
		{
			if(array[j] < array[pos_min])
			{
				pos_min = j;
				cost++;
			}
		}
		if(pos_min != i)
		{
			swap(array[i], array[pos_min]);
		}
	}
}
void msort(int array[], int lowerBound, int upperBound)
{
	int mid;
 
    if (upperBound > lowerBound)
    {
        mid = ( lowerBound + upperBound) / 2;
        msort(array, lowerBound, mid);
        msort(array, mid + 1, upperBound);
        merge(array, lowerBound, upperBound, mid);
    }
}
void merge(int array[], int lowerBound, int upperBound, int mid)
{
	int* leftArray = NULL;
    int* rightArray = NULL;
    int i, j, k;
    int n1 = mid - lowerBound + 1;
    int n2 = upperBound - mid;
    leftArray = new int[n1];
    rightArray = new int[n2];
    for (i = 0; i < n1; i++)
        leftArray[i] = array[lowerBound + i];
    for (j = 0; j < n2; j++)
        rightArray[j] = array[mid + 1 + j];
 
    i = 0;
    j = 0;
    k = lowerBound;
 
    while (i < n1 && j < n2)
    {
        if (leftArray[i] <= rightArray[j])
        {
            array[k] = leftArray[i];
            i++;
        }
        else
        {
            array[k] = rightArray[j];
            j++;
        }
 		
 		cost++;
        k++;
    }
 
    while (i < n1)
    {
        array[k] = leftArray[i];
        i++;
        k++;
    }
 
    while (j < n2)
    {
        array[k] = rightArray[j];
        j++;
        k++;
    }
 
    delete [] leftArray;
    delete [] rightArray;
}

void my_qsort(int array[], int left, int right, int (*choose_pivot)(int [], int))
{
	int size = right - left;
	int pivot = (*choose_pivot)(array+left, size);
	int i = left, j = right;
	while (i <= j) {
	    while (array[i] < pivot)
	    {
	    	cost++;
	    	i++;
	    }
	    while (array[j] > pivot)
		{
			j--;
			cost++;
		}
	    if (i <= j) {
	          swap(array[i], array[j]);
	          i++;
	          j--;
	    }
	};

	if (left < j)
	    my_qsort(array, left, j, (*choose_pivot));
	if (i < right)
	    my_qsort(array, i, right, (*choose_pivot));
}

void setCost(int setCost)
{
	cost = setCost;
}

int getCost()
{
	return cost;
}