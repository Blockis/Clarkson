mycalc: tree-calc.o tree.o
	gcc -g -o mycalc tree-calc.o tree.o
tree-calc.o: tree-calc.c
	gcc -g -c tree-calc.c
tree.o: tree.c
	gcc -g -c tree.c

clean:
	rm -rf *.o mycalc

