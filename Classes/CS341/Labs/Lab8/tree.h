#ifndef TREE_H
#define TREE_H

typedef struct tree_s
{
	int type;	/* ADDOP, MULOP or NUM */
	int attribute;	/* value */
	struct tree_s *left;
	struct tree_s *right;
}
tree_t;

tree_t *make_tree( int type, int attribute, tree_t *left, tree_t *right );
void print_tree( tree_t *t, int spaces );

#endif
