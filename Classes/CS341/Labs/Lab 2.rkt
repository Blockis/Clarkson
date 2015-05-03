#lang racket

; Paul Burgwardt
; CS341 Programming Languages
; Lab 2

; Length
(define my-length
  (lambda (ls)
    (if (null? ls)
        0
        (+ 1 (my-length (cdr ls))))))

; Append
(define my-append
  (lambda (ls1 ls2)
    (if (null? ls1)
        ls2
        (cons (car ls1) (my-append (cdr ls1)(ls2))))))

; Reverse
(define my-reverse
  (lambda (ls)
    (cond ((null? ls) '())
          (else (my-append (my-reverse (cdr ls)) (list (car ls)))))))

; Prefix
(define my-prefix
  (lambda (ls1 ls2)
    (cond ((null? ls1) #t)
          ((null? ls2) #f)
          ((equal? (car ls1) (car ls2)) (my-prefix (cdr ls1) (cdr ls2)))
          (else #f))))

; Subsequence
(define my-subsequence
  (lambda (ls1 ls2)
    (cond ((null? ls1) #t)
          ((null? ls2) #f)
          ((equal? (car ls1) (car ls2))
           (if (my-prefix ls1 ls2)
               #t
               (my-subsequence ls1 (cdr ls2))))
          (else (my-subsequence ls1 (cdr ls2))))))

; Sublist
(define sublist?
  (lambda (ls1 ls2)
    (cond ((null? ls1) #t)
          ((null? ls2) #f)
          ((equal? (car ls1) (car ls2)) (sublist? (cdr ls1) (cdr ls2)))
          (else (sublist? ls1 (cdr ls2))))))

; Map
(define my-map
  (lambda (func ls)
    (cond ((null? ls) '())
          (else (cons (func (car ls)) (my-map func (cdr ls)))))))

; Filter
(define my-filter
  (lambda (test? ls)
    (cond ((null? ls) '())
          ((test? (car ls)) (cons (car ls) (my-filter test? (cdr ls))))
          (else (my-filter test? (cdr ls))))))

; Accumulate
(define my-accumulate
  (lambda (op base term ls)
    (cond ((null? ls) base)
          (else (op (term (car ls)) (my-accumulate op base term (cdr ls)))))))

; Insert
(define my-insert
  (lambda (item ls less?)
    (cond ((null? ls) (list item))
          ((less? item (car ls)) (cons item ls))
          (else (cons (car ls) (my-insert item (cdr ls) less?))))))

; Num Sort
(define num-sort
  (lambda (ls)
    (my-sort ls <)))

; Sort
(define my-sort
  (lambda (ls less?)
    (cond ((null? ls) '())
          (else (my-insert (car ls)  (my-sort (cdr ls) less?) less?)))))

; Make Sort
(define make-sort
  (lambda (less?)
    (lambda (ls)
      (my-sort ls less?))))

; Shuffle Me
(define shuffle-me
  (lambda (ls)
    (if (< (length ls) 2) 
        ls
        (let ((item (list-ref ls (random (length ls)))))
          (cons item (shuffle-me (remove item ls)))))))