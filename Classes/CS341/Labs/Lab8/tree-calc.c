/*
 * WARNING: This is the latest version of the tree-building calculator
 *  The grammar used failed to handle a post-unary minus correctly.
 * EXERCISE: Roll back the code so that it handles a pre-unary minus
 *  correctly (alongside binary minus, among others)
 * FILES: 
 *	tree-calc.c (this file), tree.c, tree.h, tokens.h, Makefile
 * To compile (via Makefile):
 *	make clean; make
 * To run:
 *	./mycalc
 * followed by an expression to be evaluated (RETURN for end of input)
 * To exit: 
 *	CTRL-C
 */


#include <stdio.h>
#include <stdlib.h>
#include "tokens.h"
#include "tree.h"
#include <string.h>


/* global */
int token;
int attribute;

/* prototypes */
tree_t *A(), *M(), *B();

main()
{
	tree_t *value;

	/* driver for parser */
	token = tokenizer();
	value = A();

	fprintf(stderr, "\n\n");
	print_tree(value,0);

	fprintf(stderr, "\n\nValue = %d\n", eval_tree(value));
}

char* concat(int left, int right)
{
	char lbuf[1024] = "";
	char rbuf[1024] = "";
	char fbuf[2048] = "";
	snprintf(lbuf, 1024, "%d", left);
	snprintf(rbuf, 1024, "%d", right);
	strcat(fbuf, lbuf);
	strcat(fbuf, rbuf);
	return fbuf;
}

int repeat(int thing, int count)
{
	char buf[1024] = "";
	snprintf(buf, 1024, "%d", thing);
	char cThing[1024] = "";
	snprintf(cThing, 1024, "%d", thing);
	int i = 1;
	for (i = 1; i < count; i++)
	{
		snprintf(cThing, 1024, "%s", concat(strtol(cThing, NULL, 10), strtol(buf, NULL, 10)));
	}
	return strtol(cThing, NULL, 10);
}

/* semantic evaluator */
int eval_tree( tree_t *t )
{
	int lvalue, rvalue;

	if (t == NULL)
		return;

	switch(t->type) {
	case REPEAT:
		lvalue = eval_tree(t->left);
		rvalue = eval_tree(t->right);
		return repeat(lvalue, rvalue);
	case CONCAT:
		lvalue = eval_tree(t->left);
		rvalue = eval_tree(t->right);
		return strtol(concat(lvalue, rvalue), NULL, 10);
	case NUM:
		return t->attribute;		
	}
}

/* parser:
   grammar rules are
	A -> M '+' A | M '-' A | M
	M -> M '*' B | M '/' B | B
	B -> '(' A ')' | NUM
	NUM -> [0-9]+
 */

/* handler for: A -> M '+' A | M '-' A | M 
   after removing left-factoring:
	A -> M A'
	A' -> '+' A | '-' A | empty
 */
tree_t *A()
{
	tree_t *value = B();
	if (token == '^') {
		match('^');
		value = make_tree(REPEAT, '^', value, A());
	}
	else if (token == '.') {
		match('.');
		value = make_tree(CONCAT, '.', value, A());
	}
	return value;
}

/* handler for: M -> M '*' B | M '/' B | B
   after removing left-recursion:
	M -> B M'
	M' -> '*' B M' | '/' B M' | empty
 */
/*
tree_t *M()
{
	tree_t *tmp;
	tree_t *value = B();
	while (1) {
		if (token == '^') {
			match('^');
			value = make_tree(MULOP,'^',value,B());
		}
		else break;
	}
	return value;
}
*/

/* handler for: B -> '(' A ')' | A
 */
tree_t *B()
{
	tree_t *value;
	if (token == '(') {
		match('(');
		value = A();
		match(')');
		return value;
	}
/*
	else if (token == '-') {
		match('-');
		value = make_tree(UNARY, '-', B(), NULL);
		return value;
	}
	else if (token == NUM) {
		value = make_tree(NUM,attribute,NULL,NULL);
		match(NUM);	
		return value;
	}
	else error("Illegal token in B()");
*/
	else {
		value = make_tree(NUM, attribute, NULL, NULL);
		match(NUM);
		return value;
	}
}

/* match:
 */
match( int expected_token )
{
	if (token == expected_token) {
		token = tokenizer();
	}
	else {
		error("Unexpected token");
	}
}


/* scanner/tokenizer:
   split input into arithmetic tokens 
 */
int tokenizer()
{
	int c;
	int value;

	while (1) {
		switch(c = getchar()) {
		case ' ':
		case '\t':
			continue; /* ignoring whitespaces */
		case '.':
		case '^':
		case '(':
		case ')':
			fprintf(stderr, "{%c}", c);
			return c;
		default:		
			if (isdigit(c)) {
				value = 0;
				do {
					value = value*10 + (c - '0');
				} 
				while (isdigit(c = getchar()));
				ungetc(c, stdin);
				fprintf(stderr, "{NUM:%d}", value);
				attribute = value;
				return NUM;
			}
			else if (c == '\n') {
				return c;
			}
			else {
				error("Illegal character");
			}
		}
	}
}

error( char *message )
{
	fprintf(stderr, "Error: %s\n", message );
	exit(1);
}





