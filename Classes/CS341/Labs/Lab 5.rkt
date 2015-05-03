#lang racket

; Paul Burgwardt
; CS341 Programming Languages
; Lab 5

; accumulate
(define accumulate
  (lambda (op base term ls)
    (cond ((null? ls) base)
          (else (op (term (car ls))
                 (accumulate op base term (cdr ls)))))))

; filter
(define my-filter
  (lambda(test? ls)
    (cond ((null? ls) '())
          ((test? (car ls)) (cons (car ls) (my-filter test? (cdr ls))))
          (else (my-filter test? (cdr ls))))))

; exists
(define exists?
  (lambda (item ls)
    (cond ((null? ls) #f)
          ((equal? item (car ls)) #t)
          (else (exists? item (cdr ls))))))

; all-are recursive
(define all-are
  (lambda (ls test?)
    (cond ((null? ls) #t)
          ((test? (car ls)) (all-are (cdr ls) test?))
          (else #f))))

; all-are one-liner
(define all-are2?
  (lambda (ls test?)
    (accumulate (lambda (x y) (and x y))
                #t
                test?
                ls)))

; all-are filter
(define all-are3?
  (lambda (ls test?)
    (and #t (equal? (my-filter test? ls) ls))))

; edge using "and"
(define edge?
  (lambda (object)
    (and (list? object) (= 2 (length object)))))

; graph one-liner
(define graph?
	   (lambda (object)
   	       (and (list? object)
       		 (all-are2? object edge?))))

; graph recursive
(define graph2?
  (lambda (object)
    (cond ((null? object) #t)
          ((edge? (car object)) (graph2? (cdr object)))
          (else #f))))

; symmetric using accumulate
(define symmetric?
  (lambda (object)
    (and (graph? object)
         (accumulate (lambda (x y)(and x y))
                     #t
                     (lambda (edge)
                       (exists? (reverse edge)object)) object))))

; symmetric recursive
(define symmetric2?
  (lambda (ls)
    (cond ((null? ls) #t)
          ((exists? (reverse (car ls)) ls) (symmetric2? (remove (reverse (car ls)) (cdr ls))))
          (else  #f))))