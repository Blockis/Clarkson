#lang racklog

% Paul Burgwardt
% CS341 Programming Languages
% Lab 7

my_append([],Ys,Ys).
my_append([_|Xs],Ys,[_|Zs]):-
	my_append(Xs,Ys,Zs).

my_filter([],Test, []).
my_filter([X|Xs], Test,[X|Ys]) :-  
      call(Test, X), my_filter(Xs,Test,Ys).
my_filter([X|Xs], Test, Ys) :- 
      \+ call (Test, X), my_filter(Xs,Test,Ys).

my_accumulate(Op,Base,Term,[], Base).
my_accumulate(Op, Base, Term, [X|Xs], Answer) :- 
      call(Term, X, Value),
      my_accumulate(Op, Base, Term, Xs, PartialAnswer),
      call(Op, Value, PartialAnswer, Answer). 

my_member(X,[X|_]).
my_member(X,[_|Xs]) :- my_member(X,Xs).

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

% Q1: Delete all using mutually exclusive rules
delete_all(X,[],[]).
delete_all(X,[X|Xs],Ys):-
   delete_all(X,Xs,Ys).
delete_all(X, [Z|Xs], [Z|Ys]).
   \+ X = Z , delete_all(X, Xs,Ys).

% Q1: Delete all using accumulate
helper_func(X,X,[]).
helper_func(X,Y,[Y]):-
   \+ X=Y.
delete_all(X,Xs,Ys):-
   my_accumulate(append,[],helper_funct(X),Xs,Ys).

% Q1: Delete all using filter
delete_all(X,[Qs],Xs) :-
   my_filter(Qs, \==(X),Xs).

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

% Q2: Remove duplicates without exists/member
remove_duplicates([],[]).
remove_duplicates([X|Xs], [X|Ys]):-
   delete_all(X,Xs,Ys),
   remove_duplicates(Ys,Zs).

% Remove duplicates with exists/member
remove_duplicates([],[]).
remove_duplicates([X|Xs], Zs):-
    my_member(X,Xs),
    remove_duplicates(Xs, Zs).
remove_duplicates([X|Xs],[X|Zs]):-
    remove_duplicates(Xs,Zs).

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

% Q3: Set one-liner
set(Ls):- remove_duplicates(Ls,Ls).

% Q3: Set recursive
set([]).
set([Qs|Zs]):-
   \+ member[Qs,Zs],
   set(Zs).

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

% Q4: Union using append
union(Set1,Set2,Set3):-
    my_append(Set1,Set2,TemperarySet),
    remove_duplicates(TemperarySet, Set3).

% Q4: Union recursive
union([],X,X).
union([X|Y],Q,Z):-
    member(X,Q),
    union(Y,Q,Z),
union([X|Y],Q,[X|Z]):-
    union(Y,Q,Z).

%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
