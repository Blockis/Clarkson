// prototypes of sorts
void bsort(int array[], int size);
void isort(int array[], int size);
void ssort(int array[], int size);
void msort(int array[], int lowerBound, int upperBound);
void merge(int array[], int lowerBound, int upperBound, int mid);
void my_qsort(int array[], int left, int right, int (*choose_pivot)(int [], int));
void setCost(int cost);
int getCost();