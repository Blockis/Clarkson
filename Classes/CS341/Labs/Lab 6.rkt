#lang racklog

% Paul Burgwardt
% CS341 Programming Languages
% Lab 6

% my_list(+Item)
% Decides if Item is a list.
%
my_list([]).
my_list([X|Xs]) :-
	my_list(Xs).

% my_member(+Item,+List)
% Decides if Item is a member of List.
%
my_member(X,[Y|Ys]) :-
	X = Y;
        my_member(X,Ys).

% my_length(+As,-N)
% Returns the length of list As in the variable N.
%
my_length([],0).
my_length([X|Xs],N) :-
	my_length(Xs,M),
	N is M+1.

% my_append(+As,+Bs,-Cs)
% Returns the append of two lists As and Bs in the list Cs.
%
my_append([],Ys,Ys).
my_append([X|Xs],Ys,[X|Zs]) :-
	my_append(Xs,Ys,Zs).

% my_reverse(+As,-Bs)
% Returns the reverse of list As in the list Bs.
%
my_reverse([],[]).
my_reverse([X|Xs],Zs) :-
	my_reverse(Xs,As),
	my_append(As,[X],Zs).

% my_prefix(+Pattern,+List)
% Decides if Pattern is a prefix of List.
%
my_prefix(X,[Y|Ys]) :-
	X = Y.

% my_subsequence(+Pattern,+List)
% Decides if Pattern is a subsequence (consecutive) of List.
%
my_subsequence([],Xs).
my_subsequence([X|Xs],[X|Ys]) :-
	my_subsequence(Xs,Ys).
my_subsequence(Xs,[Y|Ys]) :-
	my_subsequence(Xs,Ys).

% my_delete(+Item,+List,-Answer)
% Deletes all occurrences of Item from List and returns the result in Answer.
%
my_delete(X,[],[]).
my_delete(X,[X|Xs],Zs) :-
	my_delete(X,Xs,Zs).
my_delete(X,[Y|Xs],Zs) :-
	my_delete(X,Xs,Ys),
	append([Y],Ys,Zs).