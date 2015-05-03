#include <stdio.h>
#include <stdlib.h>
#include <assert.h>
#include "tokens.h"
#include "tree.h"


tree_t *make_tree( int type, int attribute, tree_t *left, tree_t *right )
{
	tree_t *p = (tree_t *)malloc(sizeof(tree_t));
	assert(p != NULL);

	p->type = type;
	p->attribute = attribute;
	p->left = left;
	p->right = right;

	return p;
}


void print_tree( tree_t *t, int spaces )
{
	int i;

	if (t == NULL)
		return;

	for (i=0; i<spaces; i++)
		fprintf(stderr, " ");
	
	switch(t->type) {
	case ADDOP:
		fprintf(stderr, "{%c}\n", t->attribute);
		break;
	case MULOP:
		fprintf(stderr, "{%c}\n", t->attribute);
		break;
	case UNARY:
		fprintf(stderr, "{%c}\n", t->attribute);
		break;
	case NUM:
		fprintf(stderr, "[NUM:%d]\n", t->attribute);
		break;
	}

	print_tree(t->left, spaces+4);
	print_tree(t->right, spaces+4);
}







